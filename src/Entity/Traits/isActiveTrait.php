<?php


namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


trait isActiveTrait
{
    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private $isActive = false;



    public function getIsActive(): bool
    {

        return $this->isActive;
    }


    public function setIsActive(bool $isActive): self
    {

        $this->isActive = $isActive;
        return $this;
    }
}
