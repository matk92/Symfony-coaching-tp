<?php

namespace App\DataFixtures;

use App\Entity\Coach;
use App\Entity\Customer;
use App\Entity\Program;
use App\Entity\Session;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Create Coaches
        $coach1 = new Coach();
        $coach1->setFirstName('John');
        $coach1->setLastName('Doe');
        $coach1->setEmail('john.doe@example.com');
        $manager->persist($coach1);

        $coach2 = new Coach();
        $coach2->setFirstName('Alice');
        $coach2->setLastName('Johnson');
        $coach2->setEmail('alice.johnson@example.com');
        $manager->persist($coach2);

        // Create Programs
        $program1 = new Program();
        $program1->setName('Yoga Basics');
        $program1->setDescription('A beginner yoga program.');
        $program1->setDuration(30);
        $program1->setCoach($coach1);
        $manager->persist($program1);

        $program2 = new Program();
        $program2->setName('Advanced Yoga');
        $program2->setDescription('An advanced yoga program.');
        $program2->setDuration(60);
        $program2->setCoach($coach2);
        $manager->persist($program2);

        // Create Customers
        $customer1 = new Customer();
        $customer1->setFirstName('Jane');
        $customer1->setLastName('Smith');
        $customer1->setEmail('jane.smith@example.com');
        $customer1->setPassword($this->passwordHasher->hashPassword($customer1, 'password'));
        $customer1->setRoles(['ROLE_USER']);
        $manager->persist($customer1);

        $customer2 = new Customer();
        $customer2->setFirstName('Bob');
        $customer2->setLastName('Brown');
        $customer2->setEmail('bob.brown@example.com');
        $customer2->setPassword($this->passwordHasher->hashPassword($customer2, 'password'));
        $customer2->setRoles(['ROLE_USER']);
        $manager->persist($customer2);

        // Create Sessions
        $session1 = new Session();
        $session1->setDate(new \DateTime());
        $session1->setProgram($program1);
        $session1->setCustomer($customer1);
        $manager->persist($session1);

        $session2 = new Session();
        $session2->setDate(new \DateTime());
        $session2->setProgram($program2);
        $session2->setCustomer($customer2);
        $manager->persist($session2);

        $manager->flush();
    }
}