<?php
use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Basket;
use AcmeWidgetCo\Product;
use AcmeWidgetCo\DeliveryChargeRule;
use AcmeWidgetCo\Offer;

class BasketTest extends TestCase {
    private $products;
    private $deliveryChargeRules;
    private $offers;

    protected function setUp(): void {
        $this->products = [
            'R01' => new Product('R01', 32.95),
            'G01' => new Product('G01', 24.95),
            'B01' => new Product('B01', 7.95),
        ];
        
        $this->deliveryChargeRules = [
            new DeliveryChargeRule(0, 50, 4.95),
            new DeliveryChargeRule(50, 90, 2.95),
            new DeliveryChargeRule(90, PHP_INT_MAX, 0),
        ];

        $this->offers = [
            new Offer('R01', 'Buy one red widget, get the second half price', "buyOneGetSecondHalfPrice"),
        ];
    }

    public function testBasketTotal() {
        $basket = new Basket($this->products, $this->deliveryChargeRules, $this->offers);

        $basket->add('B01');
        $basket->add('G01');
        $this->assertEquals(37.85, $basket->total());

        $basket = new Basket($this->products, $this->deliveryChargeRules, $this->offers);
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEquals(54.37, $basket->total());

        $basket = new Basket($this->products, $this->deliveryChargeRules, $this->offers);
        $basket->add('R01');
        $basket->add('G01');
        $this->assertEquals(60.85, $basket->total());

        $basket = new Basket($this->products, $this->deliveryChargeRules, $this->offers);
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEquals(98.27, $basket->total());
    }
}
