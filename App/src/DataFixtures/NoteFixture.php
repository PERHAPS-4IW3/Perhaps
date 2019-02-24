<?php
/**
 * Created by PhpStorm.
 * User: 10601450
 * Date: 17/02/2019
 * Time: 14:25
 */

namespace App\DataFixtures;


use App\Entity\NoteEtCommentaire;
use App\Entity\Projet;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class NoteFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
       /* $faker = \Faker\Factory::create();
        $projets = $manager->getRepository(Projet::class)->findAll();
        $participe = $manager->getRepository(User::class)->findAll();
        for($i = 0; $i <2; $i++){
            $facture = (new NoteEtCommentaire())
                ->setCommentaire($faker->text)
                ->setNote($faker->randomNumber())
                ->setDeveloppeur($participe[array_rand($participe)])
                ->setIdProjet($projets[array_rand($projets)]);
            $manager->persist($facture);

        }
        $manager->flush();*/
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
            UserFixtures::class,
        );
    }

}