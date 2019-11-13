<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Types;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $type_0 = new Types();
        $type_0->setName("vetements");

        $type_1 = new Types();
        $type_1->setName("goodies");

        $manager->persist($type_0);
        $manager->persist($type_1);

        $manager->flush();
    }
}
