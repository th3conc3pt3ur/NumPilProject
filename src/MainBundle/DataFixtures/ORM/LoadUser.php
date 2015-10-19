<?php

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use UserBundle\Entity\User;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // On crée les users
        $user = new User();
        $user->setUsername("Passager");
        $user->setEmail("emailpassager@gmail.com");
        $user->setEnabled(1);
        $user->setPlainPassword("passager");
        $user->setPassager(true);
        // On persiste
        $manager->persist($user);
        $this->addReference('passager-user', $user);

        //on ajoute 10 pilotes pour les jeux de test
        for($i=0;$i<11;$i++)
        {
            $user = new User();
            $user->setUsername("Pilote".$i);
            $user->setEmail("emailpilote".$i."@gmail.com");
            $user->setEnabled(1);
            $user->setPlainPassword("pilote".$i);
            $user->setPilote(true);
            // On persiste
            $manager->persist($user);
            $this->addReference('pilote-user'.$i, $user);
        }


        $user = new User();
        $user->setUsername("Gestionnaire");
        $user->setEmail("gestionnaire@gmail.com");
        $user->setEnabled(1);
        $user->setPlainPassword("gestionnaire");
        $user->setGestionnaire(true);
        // On persiste
        $manager->persist($user);
        $this->addReference('gestionnaire-user', $user);

        $user = new User();
        $user->setUsername("Responsable");
        $user->setEmail("responsable@gmail.com");
        $user->setEnabled(1);
        $user->setPlainPassword("responsable");
        $user->setResponsable(true);
        // On persiste
        $manager->persist($user);
        $this->addReference('responsable-user', $user);

        // On déclenche l'enregistrement de toutes les villes
        $manager->flush();
    }
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}