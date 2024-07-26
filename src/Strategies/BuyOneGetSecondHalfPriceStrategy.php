<?php

namespace AcmeWidgetCo\Strategies;

use AcmeWidgetCo\Interfaces\OfferStrategyInterface;

class BuyOneGetSecondHalfPriceStrategy implements OfferStrategyInterface
{
    public function applyOffer(float $price, int $count): float
    {
        $discount = 0.0;
        if ($count > 1) {
            $discount = floor($count / 2) * round(($price / 2), 2);
        }
        return $discount;
    }
}
