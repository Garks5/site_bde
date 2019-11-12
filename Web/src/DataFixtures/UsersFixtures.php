<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Utilisateurs;

class UsersFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 10; $i++){
            $user = new Utilisateurs();
            $user->setNom("Yveh")
                 ->setPrenom("StLaureh")
                 ->setMail("jean.edouard@yahoo.be")
                 ->setMdp("srgbNty89S")
                 ->setLocalisation("croutte sur marne");

                 $manager->persist($user);
        }

        $manager->flush();
    }
}
