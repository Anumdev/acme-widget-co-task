<?php

namespace AcmeWidgetCo;

use AcmeWidgetCo\Interfaces\OfferStrategyInterface;

class Offer
{
    private string $productCode;
    private string $description;
    private OfferStrategyInterface $strategy;

    public function __construct(string $productCode, string $description, OfferStrategyInterface $strategy)
    {
        $this->productCode = $productCode;
        $this->description = $description;
        $this->strategy = $strategy;
    }

    public function getProductCode(): string
    {
        return $this->productCode;
    }

    public function applyOffer(float $price, int $count): float
    {
        return $this->strategy->applyOffer($price, $count);
    }
}
