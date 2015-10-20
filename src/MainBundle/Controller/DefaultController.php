<?php

namespace MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Action\RowAction;

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
            $source = new Entity('MainBundle:Vol');
            $grid = $this->container->get('grid');

            $nbPlace = new BlankColumn(array(
                'id' => 'nbPlace',
                'title' => 'Nombre de place restantes',
            ));
            $grid->addColumn($nbPlace);

            // si on est passager on créer la colonne embarquer
            //if($this->getUser()->getPassager()){
                $Embarquer = new BlankColumn(array('id' => 'Embarquer', 'title'=>'Actions'));
                $Embarquer->setSafe(false);
                $grid->addColumn($Embarquer);
            //}

            $source->manipulateRow(
                function ($row) {
                    // Place en fonction de nbPlace
                    $nbPlaces= $row->getEntity()->getNbPlaceRestantes();
                    if ($nbPlaces == "") {
                        $retour = "Pas d'avion affecté au vol";
                    } elseif ($nbPlaces > 0 ) {
                        $retour = $nbPlaces." restantes";
                    }

                    if($this->getUser()->getPassager()){
                        $vols_user = $this->getDoctrine()->getManager()->getRepository('MainBundle:Vol')->findVolByPassager($this->getUser());
                        if(in_array($this->getUser(),$row->getEntity()->getPassagers()->toArray())){
                            $row->setField('Embarquer','<span class="label label-primary">Vous embarquez déjà sur ce vol</span>');
                        }
                        elseif(count($vols_user) > 0){
                            $row->setField('Embarquer','<code>Vous avez déjà un vol de planifié</code>');
                        }else{
                            $row->setField('Embarquer', $this->renderView("MainBundle:Vol:embarquer.html.twig",array('vol'=> $row->getEntity())));
                        }

                    }
                    if($this->getUSer()->getGestionnaire()){
                        if($row->getEntity()->getAvion() != false){$row->setField('Embarquer','');}
                        else{
                            $pilotesDispo = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findPiloteDispo();
                            $avionsDispo = $this->getDoctrine()->getManager()->getRepository('MainBundle:Avion')->findAvionsDispo();
                            $row->setField('Embarquer', $this->renderView("MainBundle:Vol:button.gestion.html.twig",array('vol'=> $row->getEntity(),'pilotesDispo'=>$pilotesDispo,'avionsDispo'=>$avionsDispo)));
                        }

                    }

                    $row->setField('nbPlace', $retour);

                    $pilote = $row->getEntity()->getPilote();
                    $row->setField('pilote',$pilote);

                    $avion = $row->getEntity()->getAvion();
                    $row->setField('avion',$avion);

                    if(in_array($this->getUser(),($row->getEntity()->getPassagers()->toArray())))
                    {
                        $row->setField('Actions',"");
                    }
                    return $row;
                }
            );

            $grid->setSource($source);
            return $grid->getGridResponse('MainBundle:Vol:grid.html.twig');


            if($this->getUser()->getPassager()){ // nous sommes un passager
                $em = $this->getDoctrine()->getManager();
                // on récupère tous les vols de ce passager
                $vols_user = $em->getRepository('MainBundle:Vol')->findVolByPassager($this->getUser());
                $vols = $em->getRepository('MainBundle:Vol')->findAll();
                $paginator = $this->get('knp_paginator');

                $pagination_vol = $paginator->paginate(
                    $vols,
                    $request->query->getInt('page',1),
                    5
                );
                return $this->render("MainBundle:Default:dashboard.html.twig",array('pagination'=> $vols_user,'pagination_vol'=>$pagination_vol));
            }
            if($this->getUser()->getPilote()){ // nous sommes un pilote
                $em = $this->getDoctrine()->getManager();
                // on récupère tous les vols de ce pilote
                $vols = $em->getRepository('MainBundle:Vol')->findByPilote($this->getUser());

                $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $vols,
                    $request->query->getInt('page',1),
                    5
                );
                return $this->render("MainBundle:Default:dashboard.html.twig",array('pagination'=> $pagination));
            }
            if($this->getUser()->getGestionnaire()){ // nous sommes un gestionnaire
                $em = $this->getDoctrine()->getManager();
                // on récupère tous les vols
                $vols = $em->getRepository('MainBundle:Vol')->findAll();
                $pilotes = $em->getRepository('UserBundle:User')->findBy(array('pilote' => true));
                $pilotesDispo = $em->getRepository('UserBundle:User')->findPiloteDispo();
                $avions = $em->getRepository('MainBundle:Avion')->findAll();
                $avionsDispo = $em->getRepository('MainBundle:Avion')->findAvionsDispo();

                $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $vols,
                    $request->query->getInt('page',1),
                    5
                );
                return $this->render("MainBundle:Default:dashboard.html.twig",array('pagination'=> $pagination,'pilotes'=> $pilotes,'avions' => $avions,'pilotesDispo'=>$pilotesDispo,'avionsDispo'=>$avionsDispo));
            }
            if($this->getUser()->getResponsable()){ // nous sommes un responsable, différence gestionnaire <=> responsable ??
                $em = $this->getDoctrine()->getManager();
                // on récupère tous les vols
                $vols = $em->getRepository('MainBundle:Vol')->findAll();
                $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $vols,
                    $request->query->getInt('page',1),
                    5
                );
                $pilotes = $em->getRepository('UserBundle:User')->findBy(array('pilote' => true));
                $avions = $em->getRepository('MainBundle:Avion')->findAll();
                return $this->render("MainBundle:Default:dashboard.html.twig",array('pagination'=> $pagination,'pilotes'=> $pilotes,'avions' => $avions));
            }

        }
    }
}
