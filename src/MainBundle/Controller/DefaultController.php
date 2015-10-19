<?php

namespace MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
            if($this->getUser()->getPassager()){ // nous sommes un passager
                $em = $this->getDoctrine()->getManager();
                // on récupère tous les vols de ce passager
                $vols_user = $em->getRepository('MainBundle:Vol')->findVolByPassager($this->getUser());
                $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $vols_user,
                    $request->query->getInt('page',1),
                    5
                );
                return $this->render("MainBundle:Default:dashboard.html.twig",array('pagination'=> $pagination));
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
            if($this->getUser()->getResponsable()){ // nous sommes un responsable
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
