<?php

namespace App\Entity\Traits;

use DateTimeImmutable;
use DateTimeZone;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

trait DateTimeTrait
{

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private ?DateTimeImmutable $createAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $updateAt = null;



    public function getCreateAt(): ?DateTimeImmutable
    {

        return $this->createAt;
    }

    public function getUpdateAt(): ?DateTimeImmutable
    {
        return $this->updateAt;
    }

    #[PrePersist]
    public function onPrePersist(): void
    {
        $now = new DateTimeImmutable("now", new DateTimeZone('Europe/Paris'));

        $this->createAt = $now;

        $this->updateAt = $now;
    }


    #[PreUpdate]
    public function setUpdate(): void
    {
        $this->updateAt =  new DateTimeImmutable("now", new DateTimeZone('Europe/Paris'));
    }
}
