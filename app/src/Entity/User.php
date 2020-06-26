<?php
/**
 * User entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(
 *     name="users",
 *     uniqueConstraints={
 *     @ORM\UniqueConstraint(
 *     name="username_idx",
 *     columns={"username"},
 *          )
 *    }
 * )
 * @UniqueEntity(fields={"username"})
 */
class User implements UserInterface
{
    /**
     * Role user.
     *
     * @var string
     */
    const ROLE_USER = 'ROLE_USER';
    /**
     * Role admin.
     *
     * @var string
     */
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(
     *     name="id",
     *     type="integer",
     *     nullable=false,
     *     options={"unsigned"=true},
     * )
     */
    private $id;

    /**
     * Username.
     *
     * @var string
     *
     * @ORM\Column(type="string",
     *      length=180,
     *      unique=true
     *     )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="180",
     * )
     */
    private $username;

    /**
     * Roles.
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * The hashed password.
     *
     * @var string
     *
     * @Assert\Type(type="string")
     *
     * @Assert\Length(
     *   min = 6,
     *   max = 200
     * )
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * UserData.
     *
     * @ORM\OneToOne(targetEntity="App\Entity\UserData", inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $userdata;

    /**
     * Comment.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user", orphanRemoval=true)
     */
    private $comment;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->comment = new ArrayCollection();
    }

    /**
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     *
     * @return string User name
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * Setter for Username.
     *
     * @param string $username Username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Getter for Roles.
     *
     * @see UserInterface
     *
     * @return array Roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Setter for Roles.
     *
     * @param array $roles Roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Getter for the Password.
     *
     * @see UserInterface
     *
     * @return string|null Password
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * Setter for the Password.
     *
     * @param string $password Password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Getter for User Data.
     *
     * @return UserData|null User data entity
     */
    public function getUserdata(): ?UserData
    {
        return $this->userdata;
    }

    /**
     * Setter for UserData.
     *
     * @param UserData|null $userdata User data entity
     */
    public function setUserdata(?UserData $userdata): void
    {
        $this->userdata = $userdata;
    }

    /**
     * Getter for Comment.
     *
     * @return Collection|Comment[] Comment collection
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    /**
     * Add comment to collection.
     *
     * @param Comment $comment Comment collection
     */
    public function addComment(Comment $comment): void
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setUser($this);
        }
    }

    /**
     * Remove comment for collection.
     *
     * @param Comment $comment Comment collection
     */
    public function removeComment(Comment $comment): void
    {
        if ($this->comment->contains($comment)) {
            $this->comment->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }
    }
}
