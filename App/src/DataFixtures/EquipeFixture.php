<?php
/**
 * Created by PhpStorm.
 * User: 10601450
 * Date: 17/02/2019
 * Time: 14:17
 */

namespace App\DataFixtures;


use App\Entity\Equipe;
use App\Entity\User;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class EquipeFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $projet = $manager->getRepository(Projet::class)->findAll();
        $user = $manager->getRepository(User::class)->findAll();

        for($i = 0; $i <2; $i++){
            $competenceProjet = (new Equipe())
                ->setIdProjet($projet[array_rand($projet)])
                ->setChefDeProjet($user[array_rand($user)])
                ->addListParticipant($user[array_rand($user)])
                ->addListParticipant($user[array_rand($user)]);

            $manager->persist($competenceProjet);

        }
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
       return array(
           ProjetFixtures::class,
           UserFixtures::class,
           );
    }
}