<?php

namespace MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class VolController extends Controller
{
    /**
     * @Route("/vol/{id}", name="affectePiloteAvion")
     * @Method("POST")
     */
    public function affectePiloteAvionAction(Request $request,$id)
    {
        if($this->getUser()->getGestionnaire()){ // si on est gestionnaire
            $em = $this->getDoctrine()->getManager();
            $vol = $em->getRepository('MainBundle:Vol')->findOneById($id);
            if($vol){
                $idpilote = $request->request->getInt('idpilote');
                $idavion = $request->request->getInt('idavion');
                if($idpilote != 0){ // si on recu l'info du idpilote
                    $pilote = $em->getRepository('UserBundle:User')->findOneById($idpilote);
                    if($pilote != false){
                        $vol->setPilote($pilote);
                        $em->persist($vol);
                        $em->flush();
                    }
                }

                if($idavion != 0){ // si on a recu l'info du idavion
                    $avion = $em->getRepository('MainBundle:Avion')->findOneById($idavion);
                    if($avion != false){
                        $vol->setAvion($avion);
                        $em->persist($vol);
                        $em->flush();
                    }
                }
                return $this->redirect($this->generateUrl("homepage"));
            }
        }else{
            throw $this->createAccessDeniedException("Vous n'êtes pas gestionnaire!");
        }
    }
    /**
     * @Route("/vol/inscription/{id}", name="inscriptionVol")
     * @Method("POST")
     */
    public function inscriptionVol(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $vol = $em->getRepository("MainBundle:Vol")->find($id);
        if($vol != false){
            //vérification si le user à un vol de prévu
            $vols = $em->getRepository("MainBundle:Vol")->findVolByPassager($this->getUser());
            if(empty($vols)){ // si aucun vol de prévu on enregistre l'embarquement
                $vol->addPassager($this->getUser());
                $em->persist($vol);
                $em->flush();
                return $this->redirect($this->generateUrl("homepage"));
            }else{
                $request->getSession()->getFlashBag()->add('warning', 'Vous avez déjà embarqué !');
                return $this->redirect($this->generateUrl("homepage"));
            }
        }
    }
}
