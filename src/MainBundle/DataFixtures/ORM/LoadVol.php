<?php

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\Vol;

class LoadVol extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $vol = new Vol();
        $vol->setVilleDepart($this->getReference('Bordeaux'));
        $vol->setVilleArrivee($this->getReference('Paris'));
        $manager->persist($vol);

        $vol = new Vol();
        $vol->setVilleDepart($this->getReference('Aix en provence'));
        $vol->setVilleArrivee($this->getReference('Paris'));
        $manager->persist($vol);

        $vol = new Vol();
        $vol->setVilleDepart($this->getReference('Aix en provence'));
        $vol->setVilleArrivee($this->getReference('Bordeaux'));
        $manager->persist($vol);

        $vol = new Vol();
        $vol->setVilleDepart($this->getReference('Bordeaux'));
        $vol->setVilleArrivee($this->getReference('Aix en provence'));
        $manager->persist($vol);

        $vol = new Vol();
        $vol->setVilleDepart($this->getReference('Bordeaux'));
        $vol->setVilleArrivee($this->getReference('Lille'));
        $manager->persist($vol);

        $vol = new Vol();
        $vol->setVilleDepart($this->getReference('Lille'));
        $vol->setVilleArrivee($this->getReference('Aix en provence'));
        $manager->persist($vol);

        $manager->flush();

    }
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}