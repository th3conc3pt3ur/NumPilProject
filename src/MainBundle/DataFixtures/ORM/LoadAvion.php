<?php

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\Avion;

class LoadAvion extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // On crée l'avion
        $avion = new Avion();
        $avion->setName('Boeing 737');
        $avion->setNbPlace('189');
        // On le persist
        $manager->persist($avion);

        // On crée l'avion
        $avion = new Avion();
        $avion->setName('Boeing 747');
        $avion->setNbPlace('400');
        // On le persist
        $manager->persist($avion);

        // On déclenche l'enregistrement de toutes les avions
        $manager->flush();
    }
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}