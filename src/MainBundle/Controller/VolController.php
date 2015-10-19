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
}