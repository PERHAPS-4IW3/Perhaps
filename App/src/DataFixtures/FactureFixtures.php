<?php
/**
 * Created by PhpStorm.
 * User: 10601450
 * Date: 17/02/2019
 * Time: 11:41
 */

namespace App\DataFixtures;


use App\Entity\Devis;
use App\Entity\Facture;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class FactureFixtures extends Fixture implements DependentFixtureInterface
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
        $devis = $manager->getRepository(Devis::class)->findAll();

            $facture = (new Facture())
                ->setIdProjet( $projets[array_rand($projets)])
                ->setAutresCharges($faker->randomFloat())
                ->setDevis($devis[array_rand($devis)])
                ->setNbrHeures($faker->randomDigitNotNull)
                ->setNomFacture($faker->randomLetter)
                ->setPrixHT($faker->randomFloat())
                ->setPrixTTC($faker->randomFloat())
                ->setTauxH($faker->randomDigitNotNull);
            $manager->persist($facture);


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
                        DevisFixture::class,
            );
    }
}