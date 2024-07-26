<?php
namespace AcmeWidgetCo;

class Basket {
    private $products;
    private $deliveryChargeRules;
    private $offers;
    private $items = [];

    public function __construct($products, $deliveryChargeRules, $offers) {
        $this->products = $products;
        $this->deliveryChargeRules = $deliveryChargeRules;
        $this->offers = $offers;
    }

    public function add($productCode) {
        if (!isset($this->products[$productCode])) {
            throw new \Exception("Invalid product code: $productCode");
        }
        $this->items[] = $productCode;
    }

    public function total() {
        $total = 0.0;
        $itemCounts = [];

        foreach ($this->items as $item) {
            $total += $this->products[$item]->price;
            if (!isset($itemCounts[$item])) {
                $itemCounts[$item] = 0;
            }
            $itemCounts[$item]++;
        }

        foreach ($this->offers as $offer) {
            if (isset($itemCounts[$offer->productCode])) {
                $total -= $offer->applyOffer($this->products[$offer->productCode]->price, $itemCounts[$offer->productCode]);
            }
        }

        $deliveryCharge = 0;
        foreach ($this->deliveryChargeRules as $rule) {
            if ($total >= $rule->minAmount && $total < $rule->maxAmount) {
                $deliveryCharge = $rule->charge;
                break;
            }
        }

        return round(round($total, 2) + $deliveryCharge, 2);
    }
}
