<?php

namespace AcmeWidgetCo;

class Basket
{
    private array $products;
    private array $offers;
    private array $deliveryChargeRules;
    private array $items = [];

    public function __construct(array $products, array $offers, array $deliveryChargeRules)
    {
        $this->products = $products;
        $this->offers = $offers;
        $this->deliveryChargeRules = $deliveryChargeRules;
    }

    public function add(string $productCode): void
    {
        if (!isset($this->products[$productCode])) {
            throw new \InvalidArgumentException("Product code $productCode not found");
        }
        if (!isset($this->items[$productCode])) {
            $this->items[$productCode] = 0;
        }
        $this->items[$productCode]++;
    }

    public function total(): float
    {
        $total = 0.0;

        // Calculate total price of items
        foreach ($this->items as $productCode => $count) {
            $product = $this->products[$productCode];
            $total += $product->getPrice() * $count;
        }

        $total = round($total, 2);

        // Apply offers
        foreach ($this->offers as $offer) {
            if (isset($this->items[$offer->getProductCode()])) {
                $product = $this->products[$offer->getProductCode()];
                $total -= $offer->applyOffer($product->getPrice(), $this->items[$offer->getProductCode()]);
            }
        }

        // Apply delivery charges
        $deliveryCharge = $this->calculateDeliveryCharge($total);
        $total += $deliveryCharge;

        return round($total, 2);
    }

    private function calculateDeliveryCharge(float $total): float
    {
        usort($this->deliveryChargeRules, function ($a, $b) {
            return $b->getThreshold() <=> $a->getThreshold();
        });

        foreach ($this->deliveryChargeRules as $rule) {
             
            if ($total > $rule->getThreshold()) {
                return $rule->getCharge();
            }
        }

        return 0.0;
    }
}
