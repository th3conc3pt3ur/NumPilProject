<?php

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\Ville;

class LoadVille extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Bordeaux',
            'Aix en provence',
            'Paris',
            'Lyon',
            'Lille'
        );

        foreach ($names as $name) {
            // On crée la ville
            $ville = new Ville();
            $ville->setNom($name);

            // On la persiste
            $manager->persist($ville);
            $this->addReference($name, $ville);
        }
        // On déclenche l'enregistrement de toutes les villes
        $manager->flush();
    }
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}