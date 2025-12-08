<?php

namespace App\Model;


class Product
{





    public function __construct(
        private $name,
        private $price,
        private $category,
        private $inStock
    ) {}


    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getinStock(): bool
    {
        return $this->inStock;
    }

    public function applyPourcentag(float $percentage): float
    {
        if ($percentage < 0 || $percentage > 100) {
            throw new \InvalidArgumentException('Le nombre doit être entre 0 à 100');
        }
        return $this->price * (1 - $percentage / 100);
    }
}
