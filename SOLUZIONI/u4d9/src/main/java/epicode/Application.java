package epicode;

import epicode.entities.Customer;
import epicode.entities.Order;
import epicode.entities.Product;
import org.apache.commons.io.FileUtils;

import java.io.File;
import java.io.IOException;
import java.util.*;
import java.util.stream.Collectors;

public class Application {
    static List<Product> warehouse = new ArrayList<>();
    static List<Customer> customers = new ArrayList<>();
    static List<Order> orders = new ArrayList<>();

    public static void main(String[] args) {
        initializeWarehouse();
        createCustomers();
        placeOrders();

        printList(orders);

        System.out.println("************* 1 *****************");

        getOrdersByClient().forEach((customer, orders) -> {
            System.out.println("Il cliente: " + customer + " ha fatto " + orders.size() + " ordini");
            System.out.println("Ordini: " + orders);
        });

        System.out.println("************* 2 *****************");
        getOrdersByClientAndGetTotal().forEach((customer, total) -> System.out.println("Il cliente: " + customer + " ha speso " + total + " €"));

        System.out.println("************* 3 *****************");
        getMostExpensiveProducts().forEach(System.out::println);

        System.out.println("************* 4 *****************");
        System.out.println(getOrdersAverage());

        System.out.println("************* 5 *****************");
        System.out.println(getCategoriesAndTotals());

        System.out.println("************* 6 *****************");
        try {
            saveToDisk();
        } catch (IOException e) {
            System.err.println(e.getMessage());
        }
        System.out.println("************* 7 *****************");
        try {
            loadFromDisk().forEach(product -> System.out.println(product));
        } catch (IOException e) {
            System.err.println(e.getMessage());
        }
    }

    // 1
    public static Map<Customer, List<Order>> getOrdersByClient() {
        return orders.stream()
                .collect(Collectors.groupingBy(Order::getCustomer));
    }

    // 2
    public static Map<Customer, Double> getOrdersByClientAndGetTotal() {
        return orders.stream()
                .collect(Collectors.groupingBy(Order::getCustomer, Collectors.summingDouble(Order::getTotal)));
    }

    // 3
    public static List<Product> getMostExpensiveProducts() {
        return warehouse.stream()
                .sorted(Comparator.comparing(Product::getPrice).reversed())
                .limit(3).toList();
    }

    // 4
    public static double getOrdersAverage() {
        return orders.stream()
                .mapToDouble(Order::getTotal)
                .average()
                .orElse(0.0);
    }

    // 5
    public static Map<String, Double> getCategoriesAndTotals() {
        return warehouse.stream().collect(Collectors.groupingBy(Product::getCategory, Collectors.summingDouble((Product::getPrice))));
    }

    // 6
    public static void saveToDisk() throws IOException {
        String toWrite = "";

        for (Product product : warehouse) {
            toWrite += product.getName() + "@" + product.getCategory() + "@" + product.getPrice() + "#";
        }
        File file = new File("products.txt");
        FileUtils.writeStringToFile(file, toWrite, "UTF-8");
    }

    // 7
    public static List<Product> loadFromDisk() throws IOException {
        File file = new File("products.txt");

        String fileString = FileUtils.readFileToString(file, "UTF-8");

        List<String> splitElementiString = Arrays.asList(fileString.split("#"));

        return splitElementiString.stream().map(stringa -> {

            String[] productInfos = stringa.split("@");
            return new Product(productInfos[0], productInfos[1], Double.parseDouble(productInfos[2]));
        }).toList();

    }

    public static void printList(List<?> l) {
        for (Object obj : l) {
            System.out.println(obj);
        }
    }

    public static void initializeWarehouse() {
        Product iPhone = new Product("IPhone", "Smartphones", 2000.0);
        Product lotrBook = new Product("LOTR", "Books", 101);
        Product itBook = new Product("IT", "Books", 2);
        Product davinciBook = new Product("Da Vinci's Code", "Books", 2);
        Product diapers = new Product("Pampers", "Baby", 3);
        Product toyCar = new Product("Car", "Boys", 15);
        Product toyPlane = new Product("Plane", "Boys", 25);
        Product lego = new Product("Lego Star Wars", "Boys", 500);
        Product[] products = {iPhone, lotrBook, itBook, davinciBook, diapers, toyCar, toyPlane, lego};

        warehouse.addAll(Arrays.asList(products));
    }

    public static void createCustomers() {
        Customer aldo = new Customer("Aldo Baglio", 1);
        Customer giovanni = new Customer("Giovanni Storti", 2);
        Customer giacomo = new Customer("Giacomo Poretti", 3);
        Customer marina = new Customer("Marina Massironi", 2);

        customers.add(aldo);
        customers.add(giovanni);
        customers.add(giacomo);
        customers.add(marina);
    }

    public static void placeOrders() {
        Order aldoOrder = new Order(customers.get(0));
        Order giovanniOrder = new Order(customers.get(1));
        Order giacomoOrder = new Order(customers.get(2));
        Order marinaOrder = new Order(customers.get(3));
        Order giacomoOrder2 = new Order(customers.get(2));

        Product iPhone = warehouse.get(0);
        Product lotrBook = warehouse.get(1);
        Product itBook = warehouse.get(2);
        Product davinciBook = warehouse.get(3);
        Product diaper = warehouse.get(4);

        aldoOrder.addProduct(iPhone);
        aldoOrder.addProduct(lotrBook);
        aldoOrder.addProduct(diaper);

        giovanniOrder.addProduct(itBook);
        giovanniOrder.addProduct(davinciBook);
        giovanniOrder.addProduct(iPhone);

        giacomoOrder.addProduct(lotrBook);
        giacomoOrder.addProduct(diaper);

        marinaOrder.addProduct(diaper);

        giacomoOrder2.addProduct(iPhone);

        orders.add(aldoOrder);
        orders.add(giovanniOrder);
        orders.add(giacomoOrder);
        orders.add(marinaOrder);
        orders.add(giacomoOrder2);

    }

}
