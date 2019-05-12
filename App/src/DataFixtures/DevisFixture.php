<?php
/**
 * Created by PhpStorm.
 * User: 10601450
 * Date: 17/02/2019
 * Time: 12:55
 */

namespace App\DataFixtures;


use App\Entity\Devis;
use App\Entity\Projet;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DevisFixture extends Fixture implements  DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
       $faker = \Faker\Factory::create();
        /*$projet = $manager->getRepository(Projet::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        for($i = 0; $i <10; $i++){
            $devis = (new Devis())
                ->setProjet($projet[array_rand($projet)])
                ->setEtabliPar($users[array_rand($users)])
                ->setDateDevis($faker->dateTime)
                //->setDelaiDevis($faker->randomDigit)
                ->setDescriptionDevis($faker->paragraph)
                ->setOffreDevis($faker->numberBetween(100, 100000));
            $manager->persist($devis);

        }*/
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array( ProjetFixtures::class,
                        UserFixtures::class,);
    }
}