<?php
/**
 * Created by PhpStorm.
 * User: 10601450
 * Date: 17/02/2019
 * Time: 14:03
 */

namespace App\DataFixtures;


use App\Entity\Competence;
use App\Entity\CompetencePosseder;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CompetencePossederFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        $Users = $manager->getRepository(User::class)->findAll();
        $Competences = $manager->getRepository(Competence::class)->findAll();

        for($i = 0; $i <10; $i++){
            $CompetencePosseder = (new CompetencePosseder())
                ->setNotation($faker->randomDigitNotNull)
                ->setCompetenceId($Competences[array_rand($Competences)])
                ->setUserId($Users[array_rand($Users)]);
            $manager->persist($CompetencePosseder);

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
            UserFixtures::class,
            CompetenceFixtures::class,
        );
    }
}