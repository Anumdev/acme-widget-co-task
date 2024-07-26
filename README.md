
# Acme Widget Co Sales System Proof of Concept

This project is a proof of concept for Acme Widget Co's new sales system. The system implements a basket with delivery charge rules and special offers.

## Project Structure

```
acme-widget-co-task
├── src
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

1. **Product.php:**
   Represents a product with a code and price.
   
2. **Basket.php:**
   Manages the basket, adds products, calculates the total cost including delivery charges, and applies offers.
   
3. **DeliveryChargeRule.php:**
   Defines delivery charge rules based on the total amount spent.
   
4. **Offer.php:**
   Defines special offers and applies them to the basket.

### How It Works

1. **Initialization:**
   The `Basket` class is initialized with the product catalogue, delivery charge rules, and offers.
   
2. **Adding Products:**
   The `add` method of the `Basket` class takes a product code as a parameter and adds the corresponding product to the basket.
   
3. **Calculating Total:**
   The `total` method calculates the total cost of the basket. It:
   - Adds the prices of all products in the basket.
   - Applies any special offers.
   - Calculates the delivery charge based on the total amount spent.

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

### Example Baskets and Expected Totals

The following example baskets and their expected totals are used to verify the implementation:

| Products                   | Total  |
|----------------------------|--------|
| B01, G01                   | $37.85 |
| R01, R01                   | $54.37 |
| R01, G01                   | $60.85 |
| B01, B01, R01, R01, R01    | $98.27 |
