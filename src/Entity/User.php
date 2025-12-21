<?php

namespace App\Entity;

use App\Entity\Traits\DateTimeTrait;
use App\Entity\Traits\isActiveTrait;
use App\Entity\Traits\SluggTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_USERNAME', fields: ['username'])]
#[ORM\UniqueConstraint(name: 'UNIQ_EMAIL', fields: ['email'])]
#[ORM\UniqueConstraint(name: 'UNIQ_USERNAME_EMAIL', fields: ['username', 'email'])]
#[ORM\Index(name: 'IDX_USER_IS_ACTIVE', fields: ['isActive'])]

#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use isActiveTrait;
    use DateTimeTrait;
    use SluggTrait;


    public const USERNAME_MIN_LENGTH = 3;
    public const USERNAME_MIN_MESSAGE_LENGTH = 'Minimum au moins 3 caractères';
    public const USERNAME_MAX_LENGTH = 180;
    public const USERNAME_MAX_MESSAGE_LENGTH = "Maximum  180 caractères";
    public const USERNAME_MESSAGE_NOTBLANK = "Champ USERNAME obligatoire";


    public const EMAIL_MIN_LENGTH = 3;
    public const EMAIL_MIN_MESSAGE_LENGTH = 'Minimum au moins 3 caractères';
    public const EMAIL_MAX_LENGTH = 180;
    public const EMAIL_MAX_MESSAGE_LENGTH = "Maximum  180 caractères";
    public const EMAIL_MESSAGE_NOTBLANK = "Champ Email obligatoire";


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\Length(
        min: self::USERNAME_MIN_LENGTH,
        minMessage: self::USERNAME_MIN_MESSAGE_LENGTH,
        maxMessage: self::USERNAME_MAX_MESSAGE_LENGTH
    )]
    #[Assert\NotBlank(
        message: self::USERNAME_MESSAGE_NOTBLANK
    )]
    #[ORM\Column(type: Types::STRING, length: 30, unique: true)]
    private ?string $username = null;



    #[ORM\Column(type: Types::STRING, length: self::EMAIL_MAX_LENGTH, unique: true)]
    #[Assert\Length(
        min: self::EMAIL_MIN_LENGTH,
        minMessage: self::EMAIL_MIN_MESSAGE_LENGTH,
        maxMessage: self::EMAIL_MAX_MESSAGE_LENGTH
    )]
    #[Assert\NotBlank(
        message: self::EMAIL_MESSAGE_NOTBLANK
    )]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column()]
    private ?string $password = null;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = mb_strtolower($username);

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = mb_strtolower($email);

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getSlugSource(): ?string
    {

        return $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);

        return $data;
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
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }
}
