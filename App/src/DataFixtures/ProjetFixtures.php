<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 02/02/2019
 * Time: 16:55
 */

namespace App\DataFixtures;


use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class ProjetFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        for($i = 0; $i <10; $i++){
            $projet = (new Projet())
                ->setNomProjet('Projet Informatique '.$i)
                ->setDescriptionProjet($faker->paragraph)
                ->setBudget($faker->numberBetween(100, 100000))
                ->setChoixContact($faker->numberBetween(0, 1))
                ->setDateDebut($faker->dateTime)
                ->setCreatedAt($faker->dateTime)
                ->setCreePar($users[array_rand($users)])
                ->setIsVisible($faker->boolean);
                $manager->persist($projet);

        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array( UserFixtures::class,);
    }
}
