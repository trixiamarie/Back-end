<?php
/**
 * Cookery Lite Appearance Settings
 *
 * @package Cookery_Lite
 */

function cookery_lite_customize_register_appearance( $wp_customize ) {
    
    /** Appearance Settings */
    $wp_customize->add_panel( 
        'appearance_settings',
         array(
            'priority'    => 40,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Appearance Settings', 'cookery-lite' ),
            'description' => __( 'Customize Typography & Background Image', 'cookery-lite' ),
        ) 
    );

    /** Primary Color*/
    $wp_customize->add_setting( 
        'primary_color', 
        array(
            'default'           => '#2db68d',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ) 
    );

    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
            $wp_customize, 
            'primary_color', 
            array(
                'label'       => __( 'Primary Color', 'cookery-lite' ),
                'description' => __( 'Primary color of the theme.', 'cookery-lite' ),
                'section'     => 'colors',
                'priority'    => 5,
            )
        )
    );

    $wp_customize->add_setting( 
        'secondary_color', 
        array(
            'default'           => '#e84e3b',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ) 
    );

    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
            $wp_customize, 
            'secondary_color', 
            array(
                'label'       => __( 'Secondary Color', 'cookery-lite' ),
                'description' => __( 'Secondary color of the theme.', 'cookery-lite' ),
                'section'     => 'colors',
                'priority'    => 5,
            )
        )
    );
    
    /** Typography */
    $wp_customize->add_section(
        'typography_settings',
        array(
            'title'    => __( 'Typography', 'cookery-lite' ),
            'priority' => 15,
            'panel'    => 'appearance_settings',
        )
    );
    
    /** Primary Font */
    $wp_customize->add_setting(
		'primary_font',
		array(
			'default'			=> 'Questrial',
			'sanitize_callback' => 'cookery_lite_sanitize_select'
		)
	);

	$wp_customize->add_control(
		new Cookery_Lite_Select_Control(
    		$wp_customize,
    		'primary_font',
    		array(
                'label'	      => __( 'Primary Font', 'cookery-lite' ),
                'description' => __( 'Primary font of the site.', 'cookery-lite' ),
    			'section'     => 'typography_settings',
    			'choices'     => cookery_lite_get_all_fonts(),	
     		)
		)
	);
    
    /** Secondary Font */
    $wp_customize->add_setting(
		'secondary_font',
		array(
			'default'			=> 'Noto Serif',
			'sanitize_callback' => 'cookery_lite_sanitize_select'
		)
	);

	$wp_customize->add_control(
		new Cookery_Lite_Select_Control(
    		$wp_customize,
    		'secondary_font',
    		array(
                'label'	      => __( 'Secondary Font', 'cookery-lite' ),
                'description' => __( 'Secondary font of the site.', 'cookery-lite' ),
    			'section'     => 'typography_settings',
    			'choices'     => cookery_lite_get_all_fonts(),	
     		)
		)
	);
    
    /** Font Size*/
    $wp_customize->add_setting( 
        'font_size', 
        array(
            'default'           => 18,
            'sanitize_callback' => 'cookery_lite_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
		new Cookery_Lite_Slider_Control( 
			$wp_customize,
			'font_size',
			array(
				'section'	  => 'typography_settings',
				'label'		  => __( 'Font Size', 'cookery-lite' ),
				'description' => __( 'Change the font size of your site.', 'cookery-lite' ),
                'choices'	  => array(
					'min' 	=> 10,
					'max' 	=> 50,
					'step'	=> 1,
				)                 
			)
		)
	);

    $wp_customize->add_setting(
        'ed_localgoogle_fonts',
        array(
            'default'           => false,
            'sanitize_callback' => 'cookery_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Cookery_Lite_Toggle_Control( 
            $wp_customize,
            'ed_localgoogle_fonts',
            array(
                'section'       => 'typography_settings',
                'label'         => __( 'Load Google Fonts Locally', 'cookery-lite' ),
                'description'   => __( 'Enable to load google fonts from your own server instead from google\'s CDN. This solves privacy concerns with Google\'s CDN and their sometimes less-than-transparent policies.', 'cookery-lite' )
            )
        )
    );   

    $wp_customize->add_setting(
        'ed_preload_local_fonts',
        array(
            'default'           => false,
            'sanitize_callback' => 'cookery_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Cookery_Lite_Toggle_Control( 
            $wp_customize,
            'ed_preload_local_fonts',
            array(
                'section'       => 'typography_settings',
                'label'         => __( 'Preload Local Fonts', 'cookery-lite' ),
                'description'   => __( 'Preloading Google fonts will speed up your website speed.', 'cookery-lite' ),
                'active_callback' => 'cookery_lite_ed_localgoogle_fonts'
            )
        )
    );   

    ob_start(); ?>
        
        <span style="margin-bottom: 5px;display: block;"><?php esc_html_e( 'Click the button to reset the local fonts cache', 'cookery-lite' ); ?></span>
        
        <input type="button" class="button button-primary cookery-lite-flush-local-fonts-button" name="cookery-lite-flush-local-fonts-button" value="<?php esc_attr_e( 'Flush Local Font Files', 'cookery-lite' ); ?>" />
    <?php
    $cookery_lite_flush_button = ob_get_clean();

    $wp_customize->add_setting(
        'ed_flush_local_fonts',
        array(
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'ed_flush_local_fonts',
        array(
            'label'         => __( 'Flush Local Fonts Cache', 'cookery-lite' ),
            'section'       => 'typography_settings',
            'description'   => $cookery_lite_flush_button,
            'type'          => 'hidden',
            'active_callback' => 'cookery_lite_ed_localgoogle_fonts'
        )
    );
    
    /** Move Background Image section to appearance panel */
    $wp_customize->get_section( 'colors' )->panel              = 'appearance_settings';
    $wp_customize->get_section( 'colors' )->priority           = 5;
    $wp_customize->get_section( 'background_image' )->panel    = 'appearance_settings';
    $wp_customize->get_section( 'background_image' )->priority = 10;
}
add_action( 'customize_register', 'cookery_lite_customize_register_appearance' );