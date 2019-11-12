<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Roles;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            $role_0 = new Roles();
            $role_0->setName("Étudiant");

            $role_1 = new Roles();
            $role_1->setName("BDE");

            $role_2 = new Roles();
            $role_2->setName("Personnel CESI");

            $manager->persist($role_0);
            $manager->persist($role_1);
            $manager->persist($role_2);

        
        $manager->flush();
    }
}
