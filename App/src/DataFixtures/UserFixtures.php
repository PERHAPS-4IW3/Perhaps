<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 03/02/2019
 * Time: 22:59
 */

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        /*$faker = \Faker\Factory::create();

        for($i = 0; $i <10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->encoder->encodePassword($user, 'demo'));
            $user->setRole('ROLE_USER');
            $user->setNomUser($faker->lastName);
            $user->setPrenomUser($faker->firstName);
            $user->setAdresseUser($faker->address);
            $user->setCodePostalUser($faker->postcode);
            $user->setVille($faker->city);
            $user->setPays($faker->country);
            $user->setTelephoneUser($faker->phoneNumber);
            $user->getUpdatedAt();
            $manager->persist($user);
        }*/

       /* for($i = 0; $i <10; $i++){
            $userFreelancer = new User();
            $userFreelancer->setEmail($faker->email);
            $userFreelancer->setPassword($this->encoder->encodePassword($user, 'demo'));
            $userFreelancer->setRoles('ROLE_FREELANCER');
            $userFreelancer->setNomUser($faker->lastName);
            $userFreelancer->setPrenomUser($faker->firstName);
            $userFreelancer->setAdresseUser($faker->address);
            $userFreelancer->setCodePostalUser($faker->postcode);
            $userFreelancer->setVille($faker->city);
            $userFreelancer->setPays($faker->country);
            $userFreelancer->setTelephoneUser($faker->phoneNumber);
            $manager->persist($userFreelancer);
        }*/

        /*$manager->flush();*/

    }
}