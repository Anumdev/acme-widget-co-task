<?php

namespace AcmeWidgetCo;

class DeliveryChargeRule
{
    private float $threshold;
    private float $charge;

    public function __construct(float $threshold, float $charge)
    {
        $this->threshold = $threshold;
        $this->charge = $charge;
    }

    public function getThreshold(): float
    {
        return $this->threshold;
    }

    public function getCharge(): float
    {
        return $this->charge;
    }
}
