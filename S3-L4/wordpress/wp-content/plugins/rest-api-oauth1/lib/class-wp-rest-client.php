<?php
/**
 * REST Client.
 *
 * @package WordPress
 * @subpackage JSON API
 */

/**
 * REST Client.
 */
abstract class WP_REST_Client {

	/**
	 * Post object.
	 *
	 * @var WP_Post
	 */
	protected $post;

	/**
	 * Get the client type.
	 *
	 * Must be overridden in subclass.
	 *
	 * @return string | WP_Error
	 */
	protected static function get_type() {
		return new WP_Error( 'rest_client_missing_type', __( 'Overridden class must implement get_type', 'rest_oauth1' ) );
	}

	/**
	 * Constructor.
	 *
	 * @param WP_Post $post Underlying post data.
	 */
	protected function __construct( WP_Post $post ) {
		$this->post = $post;
	}

	/**
	 * Getter.
	 *
	 * Passes through to post object.
	 *
	 * @param string $key Key to get.
	 * @return mixed
	 */
	public function __get( $key ) {
		return $this->post->$key;
	}

	/**
	 * Isset-er.
	 *
	 * Passes through to post object.
	 *
	 * @param string $key Property to check if set.
	 * @return bool
	 */
	public function __isset( $key ) {
		return isset( $this->post->$key );
	}

	/**
	 * Update the client's post.
	 *
	 * @param array $params Parameters to update.
	 * @return bool|WP_Error True on success, error object otherwise.
	 */
	public function update( $params ) {
		$data = array();
		if ( isset( $params['name'] ) ) {
			$data['post_title'] = $params['name'];
		}
		if ( isset( $params['description'] ) ) {
			$data['post_content'] = $params['description'];
		}

		// Are we updating the post itself?
		if ( ! empty( $data ) ) {
			$data['ID'] = $this->post->ID;

			$result = wp_update_post( wp_slash( $data ), true );
			if ( is_wp_error( $result ) ) {
				return $result;
			}

			// Reload the post property.
			$this->post = get_post( $this->post->ID );
		}

		// Are we updating any meta?
		if ( ! empty( $params['meta'] ) ) {
			$meta = $params['meta'];

			foreach ( $meta as $key => $value ) {
				$existing = get_post_meta( $this->post->ID, $key, true );
				if ( $existing === $value ) {
					continue;
				}

				$did_update = update_post_meta( $this->post->ID, $key, wp_slash( $value ) );
				if ( ! $did_update ) {
					return new WP_Error(
						'rest_client_update_meta_failed',
						__( 'Could not update client metadata.', 'rest_oauth1' )
					);
				}
			}
		}

		return true;
	}

	/**
	 * Delete a client.
	 *
	 * @return bool True if delete, false otherwise.
	 */
	public function delete() {
		return (bool) wp_delete_post( $this->post->ID, true );
	}

	/**
	 * Get a client by ID.
	 *
	 * @param int $id Client post ID.
	 * @return self|WP_Error
	 */
	public static function get( $id ) {
		$post = get_post( $id );
		if ( empty( $id ) || empty( $post ) || 'json_consumer' !== $post->post_type ) {
			return new WP_Error( 'rest_oauth1_invalid_id', __( 'Client ID is not valid.', 'rest_oauth1' ), array( 'status' => 404 ) );
		}

		$class = get_called_class();

		return new $class( $post );
	}

	/**
	 * Get a client by key.
	 *
	 * @param string $key Client key.
	 * @return WP_Post|WP_Error
	 */
	public static function get_by_key( $key ) {
		$type = call_user_func( array( get_called_class(), 'get_type' ) );

		$query     = new WP_Query();
		$consumers = $query->query(
			array(
				'post_type'   => 'json_consumer',
				'post_status' => 'any',
				'meta_query'  => array(
					array(
						'key'   => 'key',
						'value' => $key,
					),
					array(
						'key'   => 'type',
						'value' => $type,
					),
				),
			)
		);

		if ( empty( $consumers ) || empty( $consumers[0] ) ) {
			return new WP_Error( 'json_consumer_notfound', __( 'Consumer Key is invalid', 'rest_oauth1' ), array( 'status' => 401 ) );
		}

		return $consumers[0];
	}

	/**
	 * Create a new client.
	 *
	 * @param array $params { .
	 *          @type string $name Client name
	 *          @type string $description Client description
	 *          @type array $meta Metadata for the client (map of key => value)
	 * }
	 * @return WP_REST_Client|WP_Error
	 */
	public static function create( $params ) {
		$default = array(
			'name'        => '',
			'description' => '',
			'meta'        => array(),
		);
		$params  = wp_parse_args( $params, $default );

		$data                 = array();
		$data['post_title']   = $params['name'];
		$data['post_content'] = $params['description'];
		$data['post_type']    = 'json_consumer';

		$id = wp_insert_post( $data, true );
		if ( is_wp_error( $id ) ) {
			return $id;
		}

		$meta         = $params['meta'];
		$class        = get_called_class();
		$meta['type'] = call_user_func( array( $class, 'get_type' ) );

		// Allow types to add their own meta too.
		$meta = call_user_func( array( $class, 'add_extra_meta' ), $meta, $params );

		/**
		 * Add extra meta to the consumer on creation.
		 *
		 * @param array $meta Metadata map of key => value
		 * @param int $id Post ID we created.
		 * @param array $params Parameters passed to create.
		 */
		$meta = apply_filters( 'json_consumer_meta', $meta, $id, $params );

		foreach ( $meta as $key => $value ) {
			update_post_meta( $id, $key, $value );
		}

		$post = get_post( $id );
		return new $class( $post );
	}

	/**
	 * Add extra meta to a post.
	 *
	 * If you'd like to add extra meta on client creation, add it here. This
	 * works the same as a filter; make sure you return the original array!
	 *
	 * @param array $meta Metadata for the post.
	 * @param array $params Parameters used to create the post.
	 * @return array Metadata to actually save.
	 */
	protected static function add_extra_meta( $meta, $params ) { //phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		return $meta;
	}

	/**
	 * Shim for get_called_class() for PHP 5.2
	 *
	 * @deprecated 0.4.0
	 * @return string Class name.
	 */
	protected static function get_called_class() {
		_deprecated_function( __METHOD__, '0.4.0', 'get_called_class()' );
		if ( function_exists( 'get_called_class' ) ) {
			return get_called_class();
		}

		// PHP 5.2 only.
		$backtrace = debug_backtrace(); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_debug_backtrace
		if ( 'call_user_func' === $backtrace[2]['function'] ) {
			return $backtrace[2]['args'][0][0];
		}
		return $backtrace[2]['class'];
	}
}
