<?php
/**
 * Created by PhpStorm.
 * User: 10601450
 * Date: 17/02/2019
 * Time: 14:22
 */

namespace App\DataFixtures;


use App\Entity\Equipe;
use App\Entity\Participe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ParticipeFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
       /* $equipe = $manager->getRepository(Equipe::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        for($i = 0; $i <10; $i++){
            $participe= (new Participe())
                ->setIdEquipe($equipe[array_rand($equipe)])
                ->setIdUser($users[array_rand($users)]);
            $manager->persist($participe);

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
        return array( UserFixtures::class,
            EquipeFixture::class,
        );
    }
}