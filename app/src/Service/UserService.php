<?php
/**
 * User service.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserService.
 * @property UserPasswordEncoderInterface passwordEncoder
 */
class UserService
{
    /**
     * User repository.
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Paginator.
     *
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * UserService constructor.
     *
     * @param UserRepository               $userRepository
     * @param PaginatorInterface           $paginator
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserRepository $userRepository, PaginatorInterface $paginator, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->paginator = $paginator;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->userRepository->queryAll(),
            $page,
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save user.
     *
     * @param User $user User entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveUser(User $user): void
    {
        $this->userRepository->saveUser($user);
    }

    /**
     * Encoding user's password.
     *
     * @param $user
     *
     * @return string
     */
    public function encodingPassword(User $user)
    {
        return $this->passwordEncoder->encodePassword(
            $user,
            $user->getPassword()
        );
    }

    /**
     * Find one by.
     *
     * @param array $criteria
     *
     * @return User|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->userRepository->findOneBy($criteria);
    }
}
