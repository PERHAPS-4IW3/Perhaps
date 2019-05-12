<?php
/**
 * Created by PhpStorm.
 * User: 10601450
 * Date: 24/02/2019
 * Time: 11:31
 */

namespace App\DataFixtures;


use App\Entity\TypeProjet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeProjetFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        /*for($i = 0; $i <10; $i++){
            $competence = (new TypeProjet())
                ->setNomType($faker->text(5));
            $manager->persist($competence);

        }*/
        $manager->flush();
    }
}