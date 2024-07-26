<?php

namespace AcmeWidgetCo\Interfaces;

interface OfferStrategyInterface
{
    public function applyOffer(float $price, int $count): float;
}