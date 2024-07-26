<?php
namespace AcmeWidgetCo;

class Offer {
    public $productCode;
    public $description;
    public $apply;

    public function __construct($productCode, $description, $apply) {
        $this->productCode = $productCode;
        $this->description = $description;
        $this->apply = $apply;
    }

    public function applyOffer($price, $count) {
        $offerName = $this->apply;
        return $this->$offerName($price, $count);
    }

    public function buyOneGetSecondHalfPrice($price, $count) {
        $discount = 0.0;
        if ($count > 1) {
            $discount = floor($count / 2) * round(($price / 2), 2);
        }
        return $discount;
    }
}
