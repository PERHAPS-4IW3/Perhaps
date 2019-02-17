<?php
/**
 * Created by PhpStorm.
 * User: 10601450
 * Date: 17/02/2019
 * Time: 11:34
 */

namespace App\DataFixtures;

use App\Entity\Competence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CompetenceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for($i = 0; $i <10; $i++){
            $competence = (new Competence())
                ->setNomCompetence($faker->text);
            $manager->persist($competence);

        }
        $manager->flush();
    }
}