<?php
/**
 * Created by PhpStorm.
 * User: 10601450
 * Date: 17/02/2019
 * Time: 14:10
 */

namespace App\DataFixtures;


use App\Entity\Competence;
use App\Entity\CompetenceProjet;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CompetenceProjetFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        $projets = $manager->getRepository(Projet::class)->findAll();
        $competences = $manager->getRepository(Competence::class)->findAll();

        for($i = 0; $i <10; $i++){
            $competenceProjet = (new CompetenceProjet())
                ->setIdCompetence($competences[array_rand($competences)])
                ->setIdProjet($projets[array_rand($projets)]);
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
            CompetenceFixtures::class,
        );
    }
}