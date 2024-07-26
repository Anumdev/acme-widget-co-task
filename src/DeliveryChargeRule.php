<?php
namespace AcmeWidgetCo;

class DeliveryChargeRule {
    public $minAmount;
    public $maxAmount;
    public $charge;

    public function __construct($minAmount, $maxAmount, $charge) {
        $this->minAmount = $minAmount;
        $this->maxAmount = $maxAmount;
        $this->charge = $charge;
    }
}
