<?php
/**
 * UserData Entity.
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserDataRepository")
 * @ORM\Table(
 *     name="userdatas",
 *     )
 * @UniqueEntity(fields={"email"})
 */
class UserData
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id",
     *     type="integer",
     *     nullable=false,
     *     options={"unsigned"=true},
     *     )
     */
    private $id;

    /**
     * Firstname.
     *
     * @var string
     *
     * @ORM\Column(type="string",
     *      length=45,
     *     )
     */
    private $firstname;

    /**
     * Lastname.
     *
     * @var string
     *
     * @ORM\Column(type="string",
     *      length=45,
     *     )
     */
    private $lastname;

    /**
     * Email.
     *
     * @var string
     *
     * @ORM\Column(type="string",
     *      length=180,
     *      unique=true
     *     )
     */
    private $email;

    /**
     * User.
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="userdata", cascade={"persist", "remove"})
     */
    private $user;

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
     * Getter for FirstName.
     *
     * @return string|null firstName
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Setter for FirstName.
     *
     * @param string $firstname FirstName
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * Getter for FirstName.
     *
     * @return string|null lastName
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Setter for LastName.
     *
     * @param string $lastname LastName
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * Getter for Email.
     *
     * @return string|null email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for Email.
     *
     * @param string $email email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Getter for User.
     *
     * @return User|null User entity
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Setter for User.
     *
     * @param User|null $user User
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
//        $newUserdata = null === $user ? null : $this;
//        if ($user->getUserdata() !== $newUserdata) {
//            $user->setUserdata($newUserdata);
//        }
    }
}
