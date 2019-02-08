<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 06/02/2019
 * Time: 18:03
 */


namespace App\Command;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'perhaps:create-user';

    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct();
        $this->objectManager = $objectManager;
    }

    protected function configure()
    {
        $this
            ->setName('user:promote')
            ->setDescription('Creates new user.')
            ->setHelp('This command allow you to create an user.')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('role', InputArgument::REQUIRED, 'The role'),
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '==============================',
            '       Create an User        ',
            '==============================',
            '',
        ]);

        $helper = $this->getHelper('question');

        $QuestionUserName = new Question('Pouvez vous rentrer le nom de votre utilisateur?');
        $bundleName = $helper->ask($input , $output , $QuestionUserName);


        $username = $input->getArgument('username');
        if (!$user = $this->objectManager->getRepository(User::class)->findOneBy(["email" => $username])) {
            throw new \Exception('User not found.');
        }

        $role = $input->getArgument('role');
        $roles = $user->getRoles();
        if (array_search($role, $roles) !== false) {
            throw new \Exception('Role already exist.');
        }

        array_push($roles, $role);

        $user->setRoles($roles);
        $this->objectManager->persist($user);
        $this->objectManager->flush();

        $output->writeln("<comment>User " . $username . " granted role " . $role . ".</comment> \n");
    }
}