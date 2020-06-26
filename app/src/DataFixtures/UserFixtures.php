<?php
/**
 * User fixtures.
 */

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserData;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures.
 */
class UserFixtures extends AbstractBaseFixtures
{
    /**
     * Password encoder.
     *
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder Password encoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'users', function ($i) {
            $user = new User();
            $user->setUsername(sprintf('user%d', $i));
            $user->setRoles([User::ROLE_USER]);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    'user1234'
                )
            );
            $userdata = new UserData();
            $userdata->setFirstname($this->faker->firstName);
            $userdata->setLastname($this->faker->lastName);
            $userdata->setEmail($this->faker->email);
            $user->setUserdata($userdata);

            return $user;
        });

        $this->createMany(3, 'admins', function ($i) {
            $user = new User();
            $user->setUsername(sprintf('admin%d', $i));
            $user->setRoles([User::ROLE_USER, User::ROLE_ADMIN]);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    'admin1234'
                )
            );
            $userdata = new UserData();
            $userdata->setFirstname($this->faker->firstName);
            $userdata->setLastname($this->faker->lastName);
            $userdata->setEmail($this->faker->email);
            $user->setUserdata($userdata);

            return $user;
        });
        $manager->flush();
    }
}
