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
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 0; $i <10; $i++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->encoder->encodePassword($user, 'demo'));
            $user->setRoles(array('ROLE_FREELANCER'));
            $user->setNomUser($faker->lastName);
            $user->setPrenomUser($faker->firstName);
            $user->setAdresseUser($faker->address);
            $user->setCodePostalUser($faker->postcode);
            $user->setVille($faker->city);
            $user->setPays($faker->country);
            $user->setTelephoneUser($faker->phoneNumber);
            $user->setIsActive(true);
            $user->getUpdatedAt();
            $manager->persist($user);

        }


            $userFreelancer = new User();
            $userFreelancer->setEmail($faker->email);
            $userFreelancer->setPassword($this->encoder->encodePassword($user, 'demo'));
            $userFreelancer->setRoles(array('ROLE_USER'));
            $userFreelancer->setNomUser($faker->lastName);
            $userFreelancer->setPrenomUser($faker->firstName);
            $userFreelancer->setAdresseUser($faker->address);
            $userFreelancer->setCodePostalUser($faker->postcode);
            $userFreelancer->setVille($faker->city);
            $userFreelancer->setPays($faker->country);
            $user->setIsActive(true);
            $userFreelancer->setTelephoneUser($faker->phoneNumber);
            $manager->persist($userFreelancer);

       
        $manager->flush();

    }
}