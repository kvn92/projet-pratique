<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Product
{
    // Utilisation de la promotion de propriétés dans le constructeur.
    // Les propriétés sont déclarées, typées et assignées dans la signature du constructeur.
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(
            min: 2,
            max: 5,
            minMessage: 'Minimum 2 caractères',
            maxMessage: "Maximum 5 caractères"
        )]
        private string $name,

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[Assert\Regex(
            pattern: '/\d{2,5}/', // Correction de la regex: d+ n'existe pas, \d+ est la bonne notation
            message: 'il besoin un chiffre pas de lettre'
        )]
        private float $price,

        #[Assert\NotBlank]
        #[Assert\Length(
            min: 2,
            max: 5,
            minMessage: 'Minimum 2 caractères',
            maxMessage: "Maximum 5 caractères"
        )]
        private string $category,

        #[Assert\NotBlank]
        #[Assert\IsTrue]
        private bool $inStock // La propriété inStock doit être un booléen pour Assert\IsTrue
    ) {
        // Le corps du constructeur est vide, car l'affectation est automatique.
    }

    // ... Vos méthodes existantes ...

    // REMARQUE: Les méthodes de lecture (Getters) restent nécessaires.

    public function getName(): string
    {
        return $this->name;
    }

    // ... autres Getters ...

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getInStock(): bool
    {
        return $this->inStock;
    }

    // ... méthode applyPourcentag ...
}
