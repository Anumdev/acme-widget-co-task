<?php

use AcmeWidgetCo\Basket;
use AcmeWidgetCo\Product;
use AcmeWidgetCo\Offer;
use AcmeWidgetCo\Strategies\BuyOneGetSecondHalfPriceStrategy;
use AcmeWidgetCo\DeliveryChargeRule;
use PHPUnit\Framework\TestCase;

class BasketTest extends TestCase
{
    private $products;
    private $offers;
    private $deliveryChargeRules;

    protected function setUp(): void
    {
        $this->products = [
            'R01' => new Product('R01', 'Red Widget', 32.95),
            'G01' => new Product('G01', 'Green Widget', 24.95),
            'B01' => new Product('B01', 'Blue Widget', 7.95),
        ];

        $this->offers = [
            new Offer('R01', 'Buy one red widget, get the second half price', new BuyOneGetSecondHalfPriceStrategy()),
        ];

        $this->deliveryChargeRules = [
            new DeliveryChargeRule(90, 0.0),
            new DeliveryChargeRule(50, 2.95),
            new DeliveryChargeRule(0, 4.95),
        ];
    }

    public function testBasketTotal()
    {
        $basket = new Basket($this->products, $this->offers, $this->deliveryChargeRules);

        $basket->add('B01');
        $basket->add('G01');
        $this->assertEquals(37.85, $basket->total());

        $basket = new Basket($this->products, $this->offers, $this->deliveryChargeRules);
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEquals(54.37, $basket->total());

        $basket = new Basket($this->products, $this->offers, $this->deliveryChargeRules);
        $basket->add('R01');
        $basket->add('G01');
        $this->assertEquals(60.85, $basket->total());

        $basket = new Basket($this->products, $this->offers, $this->deliveryChargeRules);
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEquals(98.27, $basket->total());
    }
}
