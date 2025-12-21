<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Symfony\Component\String\Slugger\AsciiSlugger;


#[ORM\UniqueConstraint(name: 'UNIQ_SLUG', fields: ['slug'])]
trait SluggTrait
{
    #[ORM\Column(type: Types::ASCII_STRING, length: 255)]
    private ?string $slug = null;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Permet de forcer un slug manuel (admin/import/fixtures)
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug ? $this->normalizeSlug($slug) : null;
        return $this;
    }

    #[PrePersist]
    public function sluggableOnPrePersist(): void
    {
        // Si pas encore de slug défini, on le génère
        if (empty($this->slug)) {
            $this->slug = $this->generateSlugFromSource();
        }
    }

    #[PreUpdate]
    public function sluggableOnPreUpdate(): void
    {
        // Si la source du slug (ex: titre) a changé, on régénère le slug
        $source = $this->getSlugSource();
        $newSlug = $source ? $this->normalizeSlug($source) : null;

        if ($newSlug && $newSlug !== $this->slug) {
            $this->slug = $newSlug;
        }
    }

    private function generateSlugFromSource(): ?string
    {
        $source = $this->getSlugSource();
        if (!$source) {
            return null;
        }
        return $this->normalizeSlug($source);
    }

    private function normalizeSlug(string $text): string
    {
        $slugger = new AsciiSlugger('fr');
        return strtolower($slugger->slug($text)->toString());
    }

    /**
     * Chaque entité doit fournir la valeur à slugifier.
     * (ex: Article => titre, User => username)
     */
    abstract protected function getSlugSource(): ?string;
}
