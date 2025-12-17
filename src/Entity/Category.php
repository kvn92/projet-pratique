<?php

namespace App\Entity;

use App\Entity\Trait\isActiveTrait;
use App\Entity\Trait\SluggTrait;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueConstraint(name: 'UNIQ_NOM', fields: ['nom'])]
class Category
{


    use isActiveTrait;
    use SluggTrait;



    const NOM_MIN_LENGTH = 3;
    const NOM_MAX_LENGTH = 40;
    const NOM_MIN_MESSAGE_LENGTH = 'il doit contenir au mon {{ limit }} caractères , vous êtes {{}}';
    const NOM_MAX_MESSAGE_LENGTH = '';
    const NOM_NOTBLANK_MESSAGE = ' {{ label }} Champ est obligatoire {{ value }}';


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\Positive()]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: self::NOM_MAX_LENGTH, unique: true)]
    #[Assert\NotBlank(
        message: self::NOM_NOTBLANK_MESSAGE
    )]
    #[Assert\Length(
        min: self::NOM_MIN_LENGTH,
        minMessage: self::NOM_MIN_MESSAGE_LENGTH,
        maxMessage: self::NOM_MAX_MESSAGE_LENGTH
    )]
    #
    private ?string $nom = null;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    protected function getSlugSource(): ?string
    {
        return $this->nom;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setCategory($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getCategory() === $this) {
                $message->setCategory(null);
            }
        }

        return $this;
    }
}
