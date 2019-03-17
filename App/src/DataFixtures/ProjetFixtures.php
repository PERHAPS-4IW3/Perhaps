<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 02/02/2019
 * Time: 16:55
 */

namespace App\DataFixtures;


use App\Entity\Projet;
use App\Entity\TypeProjet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class ProjetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        $users = $manager->getRepository(User::class)->findAll();
        $typeP = $manager->getRepository(TypeProjet::class)->findAll();
        for($i = 0; $i <10; $i++){
            $projet = (new Projet())
                ->setNomProjet('Projet Informatique '.$i)
                ->setDescriptionProjet($faker->sentences(3, true))
                ->setBudget($faker->numberBetween(100, 100000))
                ->setChoixContact($faker->numberBetween(0, 1))
                ->setDateDebut($faker->dateTime)
                //->setCreatedAt($faker->dateTime)
                ->addTypeProjet($typeP[array_rand($typeP)])
                ->setCreePar($users[array_rand($users)])
                ->setIsVisible($faker->boolean);
                $manager->persist($projet);

        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(   UserFixtures::class,
                        TypeProjetFixtures::class,
                    );
    }
}
