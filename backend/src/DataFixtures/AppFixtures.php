<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Account;
use App\Entity\Transaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // USER
        $user = new User();
        $user->setEmail('test@test.com');
        $user->setPassword('1234');

        // ACCOUNT
        $account = new Account();
        $account->setName('Compte principal');
        $account->setBalance(1500);
        $account->setOwner($user);

        // TRANSACTIONS
        $t1 = new Transaction();
        $t1->setAmount(2000);
        $t1->setType('income');
        $t1->setCreatedAt(new \DateTime());
        $t1->setAccount($account);

        $t2 = new Transaction();
        $t2->setAmount(-100);
        $t2->setType('expense');
        $t2->setCreatedAt(new \DateTime());
        $t2->setAccount($account);

        $t3 = new Transaction();
        $t3->setAmount(-50);
        $t3->setType('expense');
        $t3->setCreatedAt(new \DateTime());
        $t3->setAccount($account);

        // SAVE
        $manager->persist($user);
        $manager->persist($account);
        $manager->persist($t1);
        $manager->persist($t2);
        $manager->persist($t3);

        $manager->flush();
    }
}