<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 21/02/2019
 * Time: 23:49
 */

namespace App\Command;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateUserFreelancerCommand extends Command
{
    private $em;

    private $passwordEncoder;

    private $validator;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('perhaps:create-user-freelancer')
            ->setDescription('Create a new freelancer.')
            ->setHelp('This command allow you to create a freelancer user.')
            ->setDefinition(array(
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('prenomUser', InputArgument::REQUIRED, 'Your firstname'),
                new InputArgument('nomUser', InputArgument::REQUIRED, 'Your lastname'),
                new InputArgument('telephoneUser', InputArgument::REQUIRED, 'Your number phone'),
                new InputArgument('adresseUser', InputArgument::REQUIRED, 'Your address'),
                new InputArgument('codePostalUser', InputArgument::REQUIRED, 'Your Zip code'),
                new InputArgument('ville', InputArgument::REQUIRED, 'Your city'),
                new InputArgument('pays', InputArgument::REQUIRED, 'Your country'),
                new InputArgument('tarifHoraireFreelancer', InputArgument::REQUIRED, 'Your hourly rate'),
                new InputArgument('presentationFreelancer', InputArgument::REQUIRED, 'Your description'),
                new InputArgument('nomSociete', InputArgument::REQUIRED, 'Your company'),
                new InputArgument('password', InputArgument::REQUIRED, 'Your password'),
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = new User();
        $email = $input->getArgument('email');
        $firstname = $input->getArgument('prenomUser');
        $lastname = $input->getArgument('nomUser');
        $phone = $input->getArgument('telephoneUser');
        $address = $input->getArgument('adresseUser');
        $zip = $input->getArgument('codePostalUser');
        $city = $input->getArgument('ville');
        $country = $input->getArgument('pays');
        $hourlyRate = $input->getArgument('tarifHoraireFreelancer');
        $description = $input->getArgument('presentationFreelancer');
        $company = $input->getArgument('nomSociete');
        $password = $input->getArgument('password');

        $password = $this->passwordEncoder->encodePassword($user, $password);

        $user->setEmail($email);
        $user->setPrenomUser($firstname);
        $user->setNomUser($lastname);
        $user->setTelephoneUser($phone);
        $user->setAdresseUser($address);
        $user->setCodePostalUser($zip);
        $user->setVille($city);
        $user->setPays($country);
        $user->setTarifHoraireFreelancer($hourlyRate);
        $user->setPresentationFreelancer($description);
        $user->setNomSociete($company);
        $user->setPassword($password);
        $user->setRoles(array('ROLE_FREELANCER'));

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $errorsString = (string)$errors;
            throw new \Exception($errorsString);
        }

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln(sprintf('Created user %s', $email));

    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = array();

        if (!$input->getArgument('email')) {
            $question = new Question('Please enter an email : ');
            $questions['email'] = $question;
        }

        if (!$input->getArgument('prenomUser')) {
            $question = new Question('Please enter a firstname : ');
            $questions['prenomUser'] = $question;
        }

        if (!$input->getArgument('nomUser')) {
            $question = new Question('Please enter a lastname : ');
            $questions['nomUser'] = $question;
        }

        if (!$input->getArgument('telephoneUser')) {
            $question = new Question('Please enter a phone number : ');
            $questions['telephoneUser'] = $question;
        }

        if (!$input->getArgument('adresseUser')) {
            $question = new Question('Please enter an address : ');
            $questions['adresseUser'] = $question;
        }

        if (!$input->getArgument('codePostalUser')) {
            $question = new Question('Please enter a zip code : ');
            $questions['codePostalUser'] = $question;
        }

        if (!$input->getArgument('ville')) {
            $question = new Question('Please enter a city : ');
            $questions['ville'] = $question;
        }

        if (!$input->getArgument('pays')) {
            $question = new Question('Please enter a country : ');
            $questions['pays'] = $question;
        }

        if (!$input->getArgument('tarifHoraireFreelancer')) {
            $question = new Question('Please enter a hourly rate : ');
            $questions['tarifHoraireFreelancer'] = $question;
        }

        if (!$input->getArgument('presentationFreelancer')) {
            $question = new Question('Please enter a short description : ');
            $questions['presentationFreelancer'] = $question;
        }

        if (!$input->getArgument('nomSociete')) {
            $question = new Question('Please enter your company name : ');
            $questions['nomSociete'] = $question;
        }

        if (!$input->getArgument('password')) {
            $question = new Question('Please choose a password : ');
            $question->setHidden(true);
            $question->setHiddenFallback(false);
            $questions['password'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}