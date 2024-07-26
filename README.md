
# Acme Widget Co Sales System Proof of Concept

This project is a proof of concept for Acme Widget Co's new sales system. The system implements a basket with delivery charge rules and special offers.

## Project Structure

```
acme-widget-co-task
├── src
├───Interfaces
│   │   │   OfferStrategyInterface.php # Interface for Offer Strategy implementation
│   ├───Strategies
│   │   │   BuyOneGetSecondHalfPriceStrategy.php # Price Strategy class implementation
│
│   ├── Basket.php                   # The Basket class implementation
│   ├── Product.php                  # The Product class implementation
│   ├── DeliveryChargeRule.php       # The DeliveryChargeRule class implementation
│   └── Offer.php                    # The Offer class implementation
├── tests
│   ├── BasketTest.php               # Unit tests for the Basket class
├── composer.json                    # Composer configuration for dependencies
├── composer.lock                    # Composer lock file
├── phpstan.neon                     # PHPStan configuration
├── phpunit.xml                      # PHPUnit configuration
└── README.md                        # Project README file
```

## Setup

### Prerequisites

- Docker
- Docker Compose

### Installation

1. Clone the repository:
    ```sh
    git clone <repository-url>
    cd acme-widget-co-task
    ```

2. Build and run the Docker container:
    ```sh
    docker-compose up --build
    ```

3. Run tests:
    ```sh
    docker-compose exec app vendor/bin/phpunit
    ```

## Project Explanation

### Classes and Files

1. **Interfaces/OfferStrategyInterface.php:**
   Defines an interface for offer strategies. It includes a method to apply the offer to a product.

2. **Strategies/BuyOneGetSecondHalfPriceStrategy.php:**
   Implements the `OfferStrategyInterface`. It provides the logic for the "buy one red widget, get the second half price" offer.

3. **Product.php:**
   Represents a product with a code, name, and price.

4. **Basket.php:**
   Manages the basket. It allows adding products, calculates the total cost including delivery charges, and applies offers.

5. **DeliveryChargeRule.php:**
   Defines delivery charge rules based on the total amount spent.

6. **Offer.php:**
   Defines special offers. It associates a product code with an offer strategy and applies the offer to the basket.


### How It Works

1. **Initialization:**
   The `Basket` class is initialized with the product catalog, delivery charge rules, and offers. Products are represented as an associative array with product codes as keys and `Product` objects as values. Delivery charge rules and offers are arrays of `DeliveryChargeRule` and `Offer` objects, respectively.

2. **Adding Products:**
   The `add` method of the `Basket` class takes a product code as a parameter and adds the corresponding product to the basket. If the product code is not found in the catalog, an `InvalidArgumentException` is thrown.

3. **Calculating Total:**
   The `total` method calculates the total cost of the basket. It:
   - Calculates the total price of all products in the basket.
   - Applies any special offers using the strategy defined in the `Offer` class.
   - Calculates the delivery charge based on the total amount spent, according to the predefined delivery charge rules.


### Assumptions

1. **Product Codes:**
   It is assumed that product codes are unique and valid.
   
2. **Offers:**
   Special offers are defined as functions and passed as callables to the `Offer` class. The initial offer implemented is "buy one red widget, get the second half price".
   
3. **Delivery Charges:**
   Delivery charges are applied based on predefined rules:
   - Orders under $50 cost $4.95.
   - Orders under $90 cost $2.95.
   - Orders of $90 or more have free delivery.

## Additional Concepts and Usage

### PHPUnit (Unit and Integration Tests)

PHPUnit is used to write and execute tests for the project. Unit tests focus on testing individual components, such as methods in the `Basket` class, ensuring they work correctly in isolation. Integration tests verify that different parts of the system work together as expected. The `BasketTest.php` file contains the test cases for the `Basket` class.

### Docker Compose

Docker Compose is used to set up and manage the project environment. It allows for the definition and running of multi-container Docker applications. In this project, Docker Compose is used to build and run the application in a containerized environment, ensuring consistency across different development setups.

### Dependency Injection

Dependency Injection (DI) is used to manage the dependencies of classes, promoting loose coupling and easier testing. In this project, DI is used to inject the product catalog, delivery charge rules, and offers into the `Basket` class during its initialization. This makes it easier to manage dependencies and to mock them during testing.

### Strategy Pattern

The Strategy Pattern is used to define and apply different pricing strategies for offers. The project includes an `OfferStrategyInterface` that defines a method for applying offers. Concrete implementations of this interface, such as `BuyOneGetSecondHalfPriceStrategy`, encapsulate the specific logic for each offer. This pattern allows the `Basket` class to apply different offers dynamically.

### Sensible Types

Sensible types refer to the use of appropriate data types and type hinting in method signatures and class properties to ensure type safety and clarity. In this project, sensible types are used throughout the codebase, with type hints for parameters and return types, ensuring that the expected types are enforced. This reduces errors and improves code readability and maintainability.

### Encapsulation

Encapsulation is use to hide specific information and control access to the object’s internal state. In this project `Product`, `Offer` and `DeliveryChargeRule` classes use encapsulation.

### Example Baskets and Expected Totals

The following example baskets and their expected totals are used to verify the implementation:

| Products                   | Total  |
|----------------------------|--------|
| B01, G01                   | $37.85 |
| R01, R01                   | $54.37 |
| R01, G01                   | $60.85 |
| B01, B01, R01, R01, R01    | $98.27 |
