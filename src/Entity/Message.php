<?php

namespace App\Entity;

use App\Entity\Traits\DateTimeTrait;
use App\Entity\Traits\isActiveTrait;
use App\Entity\Traits\SluggTrait;
use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MessageRepository::class)]

#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'UNIQ_TITRE', fields: ['titre'])]
#[ORM\Index(name: 'IDX_MESSAGE_IS_ACTIVE', fields: ['isActive'])]



class Message
{

    use isActiveTrait;
    use DateTimeTrait;
    use SluggTrait;


    public const TITRE_MIN_LENGHT = 3;
    public const TITRE_MIN_MESSAGE_LENGHT = "Caractères minimum {{ limit }}";
    public const TITRE_MAX_LENGHT = 255;
    public const TITRE_MAX_MESSAGE_LENGHT = "Caractères maximun {{ limit }}";
    public const TITRE_MESSAGE_NOTBLANK = "Champs obligatoire";
    public const TITRE_REGEX = '/^[\p{L}\p{N}\s\r\n\p{P}\'"°()...]*$/u';
    public const TITRE_MESSAGE_REGEX = 'La description contient des caractères non autorisés.';

    const MESSAGE_MESSAGE_NOTBLANK = "Champs  message obligatoire";




    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: self::TITRE_MAX_LENGHT, unique: true)]
    #[Assert\Length(
        mix: self::TITRE_MIN_LENGHT,
        minMessage: self::TITRE_MIN_MESSAGE_LENGHT,
        maxMessage: self::TITRE_MAX_MESSAGE_LENGHT

    )]
    #[Assert\NotBlank(
        message: self::TITRE_MESSAGE_NOTBLANK
    )]
    #[Assert\Regex(
        pattern: self::TITRE_REGEX,
        message: self::TITRE_MESSAGE_REGEX
    )]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(
        message: self::MESSAGE_MESSAGE_NOTBLANK
    )]
    private ?string $message = null;


    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(
        name: 'user_id',
        referencedColumnName: 'id',
        nullable: false,
    )]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(
        nullable: false,
    )]
    private ?Category $category = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = mb_strtolower($titre);

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }


    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getSlugSource(): ?string
    {

        return $this->titre;
    }
}
