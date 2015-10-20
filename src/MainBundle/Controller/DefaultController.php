<?php

namespace MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Column\BlankColumn;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // si on est pas authentifier on reroute sur le login
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

            return $this->redirect($this->generateUrl("fos_user_security_login"));
        }
        else{
            // on déclare la GRID
            $source = new Entity('MainBundle:Vol');
            $grid = $this->container->get('grid');

            // on ajoute la colonne du nombre place restantes
            $nbPlace = new BlankColumn(array(
                'id' => 'nbPlace',
                'title' => 'Nombre de place restantes',
            ));
            $grid->addColumn($nbPlace);

            // on ajoute la colonne custom pour gérer les actions
            $Embarquer = new BlankColumn(array('id' => 'Embarquer', 'title'=>'Actions'));
            $Embarquer->setSafe(false);
            $grid->addColumn($Embarquer);

            // on modifier les lignes
            $source->manipulateRow(
                function ($row) {
                    // On gère le nombre de place
                    $nbPlaces= $row->getEntity()->getNbPlaceRestantes();
                    if ($nbPlaces == "") {
                        $retour = "Pas d'avion affecté au vol";
                    } elseif ($nbPlaces > 0 ) {
                        $retour = $nbPlaces." restantes";
                    }
                    $row->setField('nbPlace', $retour);

                    if($this->getUser()->getPassager()){
                        $vols_user = $this->getDoctrine()->getManager()->getRepository('MainBundle:Vol')->findVolByPassager($this->getUser());
                        if(in_array($this->getUser(),$row->getEntity()->getPassagers()->toArray())){ // si le user est dans ce vol
                            $row->setField('Embarquer','<span class="label label-primary">Vous embarquez déjà sur ce vol</span>');
                        }
                        elseif(count($vols_user) > 0){ // si il n'y pas dans le vol en cours mais en a un
                            $row->setField('Embarquer','<code>Vous avez déjà un vol de planifié</code>');
                        }else{
                            $row->setField('Embarquer', $this->renderView("MainBundle:Vol:embarquer.html.twig",array('vol'=> $row->getEntity())));
                        }

                    }
                    if($this->getUSer()->getGestionnaire()){
                        if($row->getEntity()->getAvion() != false && $row->getEntity()->getPilote() != false){$row->setField('Embarquer','');} // si on a un avion et un pilote rien a faire
                        else{
                            $pilotesDispo = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findPiloteDispo();
                            $avionsDispo = $this->getDoctrine()->getManager()->getRepository('MainBundle:Avion')->findAvionsDispo();
                            $row->setField('Embarquer', $this->renderView("MainBundle:Vol:button.gestion.html.twig",array('vol'=> $row->getEntity(),'pilotesDispo'=>$pilotesDispo,'avionsDispo'=>$avionsDispo)));
                        }

                    }
                    return $row;
                }
            );
            $grid->setSource($source);
            return $grid->getGridResponse('MainBundle:Vol:grid.html.twig');
        }
    }
}
