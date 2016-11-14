<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Agence;
use AppBundle\Entity\Annonce;
use AppBundle\Entity\Compte;
use AppBundle\Entity\Image;
use AppBundle\Entity\Immobilier;
use AppBundle\Entity\InfoAnnonce;
use AppBundle\Entity\Notification;
use AppBundle\Entity\Paiement;
use AppBundle\Entity\Personne;
use AppBundle\Entity\Postuler;
use AppBundle\Entity\ProfilNotification;
use AppBundle\Entity\Reservation;
use AppBundle\Form\ImageType2;
use AppBundle\Form\ImmobilierType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Admin controller.
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/index10", name="index_page")
     */
    public function indexAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        // $notif=$this->get('notification');
        //$notif->entityNotifications('Compte');
        //var_dump()

        return $this->render(':admin/NiceAdmin:index.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/404", name="error_page")
     */
    public function errorAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render(':admin:NiceAdmin:404.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/basic_table", name="basic_table_page")
     */
    public function basic_tableAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render(':admin:NiceAdmin:basic_table.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/blank", name="blank_page")
     */
    public function blankAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render(':admin:NiceAdmin:blank.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/chart", name="chart_page")
     */
    public function chartAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render(':admin:NiceAdmin:chart-chartjs.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/buttons", name="buttons_page")
     */
    public function buttonsAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render(':admin:NiceAdmin:buttons.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/form_component", name="form_component_page")
     */
    public function form_componentAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render(':admin:NiceAdmin:form_component.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/general", name="general_page")
     */
    public function generalAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render(':admin:NiceAdmin:general.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/grids", name="grids_page")
     */
    public function gridsAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render(':admin:NiceAdmin:grids.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/profile", name="profile_page")
     */
    public function profileAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render(':admin:NiceAdmin:profile.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/widgets", name="widgets_page")
     */
    public function widgetsAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render(':admin:NiceAdmin:widgets.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/form_validation", name="form_validation_page")
     */
    public function form_validationAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render(':admin:NiceAdmin:form_validation.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/form_login", name="form_login_page")
     */
    public function form_loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render(':admin:NiceAdmin:login.html.twig', array('last_username' => $lastUsername,
            'error' => $error,
            'user' => $user));
    }

    /**
     * @Route("/liste_user", name="liste_user_page")
     */
    public function liste_userAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $personnes = $em->getRepository('AppBundle:Personne')->findAll();

        return $this->render(':admin:NiceAdmin:users.html.twig', array(
            'personnes' => $personnes, 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }
    //**********************************************Utilisateur***************************************************
    /**
     * Lists all Utilisateur entities.
     *
     * @Route("/Utilisateur/", name="utilisateur_index")
     * @Method("GET")
     */
    public function indexUtilisateurAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $comptes = $em->getRepository('AppBundle:Compte')->findby(array('active' => true), array('dateCreation' => 'DESC'));
        //  $pere = $em->getRepository('AppBundle:Personne')->findAll();
        $personnes = array();
        if ($comptes) {
            foreach ($comptes as $c) {
                $personnes[] = $em->getRepository('AppBundle:Personne')->findOneByCompte($c);

            }
        }

            $profilNotifs = $em->getRepository('AppBundle:ProfilNotification')->findby(array('active' => true));
            $typeNotifications = $em->getRepository('AppBundle:TypeNotification')->findby(array('entite' => 'Personne'));
            foreach ($profilNotifs as $profilNotif) {
                foreach ($typeNotifications as $typeNotification) {
                    if ($profilNotif->getTypeNotification() == $typeNotification) {
                        $profilNotif->setActive(false);
                        $em->merge($profilNotif);
                        $em->flush();
                    }
                }
            }


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($personnes, $request->query->getInt('page', 1), 5);

        //$personnes = $em->getRepository('AppBundle:Personne')->findsAllComptes();

        return $this->render(':admin:utilisateur/index.html.twig', array('pagination' => $pagination,
            'personnes' => $personnes, 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Creates a new Utilisateur entity.
     *
     * @Route("/Utilisateur/new", name="utilisateur_new")
     * @Method({"GET", "POST"})
     */
    public function newUtilisateurAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $personne = new Personne();
        $compte = new Compte();
        $form = $this->createForm('AppBundle\Form\PersonneType', $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $compte = $personne->getCompte();
            $encoder = $this->get('security.password_encoder');
            $compte->setPassword($encoder->encodePassword($user, $compte->getPassword()/*,$compte->getSalt()*/));
            $compte->setDateCreation(new \DateTime('now'));
            $compte->setActive(true);
            $em->persist($compte);
            $em->persist($personne);
            $em->flush();

            $notif = new Notification();
            $notif->setCompte($user);
            $notif->setDateNotification(new \DateTime());
            $notif->setIdEntity($compte->getCompteId());
            $em->persist($notif);

            $profilNotif = new ProfilNotification();
            $profilNotif->setCompte($compte);
            $profilNotif->setActive(true);

            $profilNotif->setNotification($notif);
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(11));

            $em->persist($profilNotif);

            $em->flush();
            return $this->redirectToRoute('utilisateur_index', array('id' => $personne->getPersonneId()));
        }

        return $this->render(':admin:utilisateur/new.html.twig', array(
            'personne' => $personne, 'compte' => $compte,
            'form' => $form->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }


    /**
     * Finds and displays a Utilisateur entity.
     *
     * @Route("/Utilisateur/{id}", name="utilisateur_show")
     * @Method("GET")
     */
    public function showUtilisateurAction(Personne $personne)
    {
        $em = $this->getDoctrine()->getManager();
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createUtilisateurDeleteForm($personne);

            $profilNotifs = $em->getRepository('AppBundle:ProfilNotification')->findby(array('active' => true));
            $typeNotifications = $em->getRepository('AppBundle:TypeNotification')->findby(array('entite' => 'Personne'));
            foreach ($profilNotifs as $profilNotif) {
                foreach ($typeNotifications as $typeNotification) {
                   // if ($profilNotif->getNotification() == $typeNotification) {
                        if($personne->getPersonneId()==$profilNotif->getNotification()->getIdEntity()){
                        $profilNotif->setActive(false);
                        $em->persist($profilNotif);
                        $em->flush();
                        }
                   // }
                }
            }

        return $this->render(':admin:utilisateur/profile.html.twig', array(
            'personne' => $personne,
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing Utilisateur entity.
     *
     * @Route("/Utilisateur/{id}/edit", name="utilisateur_edit")
     * @Method({"GET", "POST"})
     */
    public function editUtilisateurAction(Request $request, Personne $personne)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createUtilisateurDeleteForm($personne);
        $editForm = $this->createForm('AppBundle\Form\PersonneType', $personne);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($personne);
            $em->flush();
            $notif = new Notification();
            $notif->setCompte($user);
            $notif->setDateNotification(new \DateTime());
            $notif->setIdEntity($personne->getPersonneId());
            $em->persist($notif);

            $profilNotif = new ProfilNotification();
            $profilNotif->setCompte($personne->getCompte());
            $profilNotif->setActive(true);

            $profilNotif->setNotification($notif);
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(12));

            $em->persist($profilNotif);

            $em->flush();
            return $this->redirectToRoute('utilisateur_index', array('id' => $personne->getPersonneId()));
        }

        return $this->render(':admin:utilisateur/edit.html.twig', array(
            'personne' => $personne,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Deletes a Utilisateur entity.
     *
     * @Route("/Utilisateur/{id}/delete", name="utilisateur_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteUtilisateurAction(Request $request, Personne $personne)
    {
        $em = $this->getDoctrine()->getManager();
        $compte = $em->getRepository('AppBundle:Compte')->find($personne->getCompte());
        if (!$compte) {
            throw $this->createNotFoundException('No guest found for id ' . $personne->getCompte());
        }
        $compte->setActive(true);
        $em->merge($compte);
        $em->flush();
        return $this->redirect($this->generateUrl('utilisateur_index'));
    }

    /**
     * Creates a form to delete a Personne entity.
     *
     * @param Personne $personne The Personne entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createUtilisateurDeleteForm(Personne $personne)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('utilisateur_delete', array('id' => $personne->getPersonneId())))
            ->setMethod('DELETE')
            ->getForm();
    }
    //*******************************************************************************************************
    //********************************************** Compte ***************************************************
    /**
     * Lists all Compte entities.
     *
     * @Route("/Comptes/", name="comptes_index")
     * @Method("GET")
     */
    public function indexComptesAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $comptes = $em->getRepository('AppBundle:Compte')->findby(array(), array('dateCreation' => 'DESC'));

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($comptes, $request->query->getInt('page', 1), 5);

        $profilNotifs = $em->getRepository('AppBundle:ProfilNotification')->findby(array('active' => true));
        $typeNotifications = $em->getRepository('AppBundle:TypeNotification')->findby(array('entite' => 'Compte'));
        foreach ($profilNotifs as $profilNotif) {
            foreach ($typeNotifications as $typeNotification) {
                if ($profilNotif->getTypeNotification() == $typeNotification) {
                    $profilNotif->setActive(false);
                    $em->merge($profilNotif);
                    $em->flush();
                }
            }
        }
        // parameters to template

        return $this->render(':admin:comptes/index.html.twig', array('pagination' => $pagination,
            'comptes' => $comptes, 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Creates a new Compte entity.
     *
     * @Route("/Comptes/new", name="comptes_new")
     * @Method({"GET", "POST"})
     */
    public function newComptesAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $compte = new Compte();
        $personne = new Personne();
        $form = $this->createForm('AppBundle\Form\CompteForm', $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($compte);
            $em->flush();
            $em1 = $this->getDoctrine()->getManager();
            $personne->setCompte($compte);
            $em1->persist($personne);
            $em1->flush();
            return $this->redirectToRoute('comptes_show', array('id' => $compte));
        }

        return $this->render(':admin:comptes/new.html.twig', array(
            'compte' => $compte,
            'form' => $form->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Finds and displays a Compte entity.
     *
     * @Route("/Comptes/{id}/Profile", name="comptes_show")
     * @Method("GET")
     */
    public function showComptesProfileAction(Request $request, Compte $compte)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // $deleteForm = $this->createComptesDeleteForm($compte);

        $em = $this->getDoctrine()->getManager();

        $personne = $em->getRepository('AppBundle:Personne')->findOneByCompte($compte);
        //$role= $em->getRepository('AppBundle:Role')->findOneByCompte($compte);

        return $this->render(':admin:comptes/profile.html.twig', array(
            'compte' => $compte, 'personne' => $personne,/*'role'=>$role,*/
            /*'delete_form' => $deleteForm->createView(),*/
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }


    /**
     * Displays a form to edit an existing Compte entity.
     *
     * @Route("/Comptes/{id}/edit", name="comptes_edit")
     * @Method({"GET", "POST"})
     */
    public function editComptesAction(Request $request, Compte $compte)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createComptesDeleteForm($compte);
        $editForm = $this->createForm('AppBundle\Form\CompteForm', $compte);
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        if ($compte->getActive() == true) {
            $compte->setActive(false);
        } else {
            $compte->setActive(true);
        }
        $em->merge($compte);
        $em->flush();
        $annonces = $em
            ->getRepository('AppBundle:Annonce')
            ->findBy(array('depositaire' => $compte));
        foreach ($annonces as $annonce) {
            if ($annonce->getDepositaire()->getCompte() == $compte) {
                if ($compte->getActive() == true) {
                    $annonce->setEtat("Valider");
                } else {
                    $annonce->setEtat("Desactiver");
                }
            }
            $em->merge($annonce);
            $em->flush();
        }
        $notif = new Notification();
        $notif->setCompte($user);
        $notif->setDateNotification(new \DateTime());

        /*  if ($compte->getActive() == true) {*/

        //$annonce->setEtat("Valider");
        $notif->setIdEntity($compte->getCompteId());
        /* } else {
             //$annonce->setEtat("Desactiver");
             $notif->setIdEntity(8);

         }*/

        $em->persist($notif);

        $profilNotif = new ProfilNotification();
        $profilNotif->setCompte($compte);
        $profilNotif->setActive(true);

        $profilNotif->setNotification($notif);

        if ($compte->getActive() == true) {
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(9));

        } else {
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(10));

        }


        $em->persist($profilNotif);

        $em->flush();
        $comptes = $em->getRepository('AppBundle:Compte')->findby(array(), array('dateCreation' => 'DESC'));
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($comptes, $request->query->getInt('page', 1), 5);

        return $this->render(':admin:comptes/index.html.twig', array('pagination' => $pagination,
            'comptes' => $comptes, 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Deletes a Compte entity.
     *
     * @Route("/Comptes/{id}", name="comptes_delete")
     * @Method("DELETE")
     */
    public function deleteComptesAction(Request $request, Compte $compte)
    {
        $form = $this->createComptesDeleteForm($compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($compte);
            $em->flush();
        }

        return $this->redirectToRoute('comptes_index');
    }

    /**
     * Creates a form to delete a Compte entity.
     *
     * @param Compte $compte The Compte entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createComptesDeleteForm(Compte $compte)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comptes_delete', array('id' => $compte->getCompteId())))
            ->setMethod('DELETE')
            ->getForm();
    }
    //*******************************************************************************************************
    //********************************************** Immobilier ***************************************************
    /**
     * Lists all Immobilier entities.
     *
     * @Route("/Immobiliers/", name="immobiliers_index")
     * @Method("GET")
     */
    public function indexImmobiliersAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $profilNotifs = $em->getRepository('AppBundle:ProfilNotification')->findby(array('active' => true));
        $typeNotifications = $em->getRepository('AppBundle:TypeNotification')->findby(array('entite' => 'Immobilier'));
        foreach ($profilNotifs as $profilNotif) {
            foreach ($typeNotifications as $typeNotification) {
                if ($profilNotif->getTypeNotification() == $typeNotification) {
                    $profilNotif->setActive(false);
                    $em->merge($profilNotif);
                    $em->flush();
                }
            }
        }
        $immobiliers = $em->getRepository('AppBundle:Immobilier')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($immobiliers, $request->query->getInt('page', 1), 5);
        return $this->render(':admin:immobiliers/index.html.twig', array('pagination' => $pagination,
            'immobiliers' => $immobiliers, 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Creates a new Immobilier entity.
     *
     * @Route("/Immobiliers/new", name="immobiliers_new")
     * @Method({"GET", "POST"})
     */
    public function newImmobiliersAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $form = $this->createFormBuilder()
            ->add('immobilier', ImmobilierType::class)
            ->add('files', FileType::class, array(
                'label' => 'Image(s) du Bien :', 'label_attr' => array('class' => 'control-label col-lg-6'),
                'multiple' => true,
                'data_class' => null))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $immobilier = $form['immobilier']->getData();
            $files = $form['files']->getData();
            if ($request->request->has('mon_quartier')) {
                $quarterId = intval($request->request->get('mon_quartier'));
                $quarter = $em->getRepository('AppBundle:Quartier')
                    ->find($quarterId);
                $immobilier->setQuartier($quarter);
            }
            $em->persist($immobilier);
            $em->flush();
            $fileService = $this->get('file_upload');
            $fileService->setFiles($files);
            $fileService->upload($immobilier);
            $mesImages = $fileService->getImages();

            if (null !== $mesImages) {
                foreach ($mesImages as $img) {
                    $em->persist($img);
                    $immobilier->setMainImage($img);
                }
            }
            $em->flush();
            $em->merge($immobilier);
            $em->flush();

            $notif = new Notification();
            $notif->setCompte($user);
            $notif->setDateNotification(new \DateTime());
            $notif->setIdEntity($immobilier->getImmobilierId());
            $em->persist($notif);

            $profilNotif = new ProfilNotification();
            $profilNotif->setCompte($immobilier->getProprietaire()->getCompte());
            $profilNotif->setActive(true);

            $profilNotif->setNotification($notif);
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(3));

            $em->persist($profilNotif);

            $em->flush();
            return $this->redirectToRoute('immobiliers_index'/*, array('id' => $immobilier->getImmobilierId())*/);
        }

        return $this->render(':admin:immobiliers/new.html.twig', array(

            'form' => $form->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Creates a new Immobilier entity.
     *
     * @Route("/Immobiliers/photo", name="immobiliers_newphoto")
     * @Method({"GET", "POST"})
     */
    public function newPhotoImmobiliersAction(Request $request, Immobilier $immobilier)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        //$immobilier = new Immobilier();
        //$form = $this->createForm('AppBundle\Form\ImmobilierType', $immobilier);
        /*$form->handleRequest($request);*/
        //$em = $this->getDoctrine()->getManager();

        //$typeimmobiliers= $em->getRepository('AppBundle:Typeimmobilier')->findAll();
        $form = $this->createFormBuilder()
            ->add('files', FileType::class, array(
                'label' => 'Image(s) du Bien :', 'label_attr' => array('class' => 'control-label col-lg-6'),
                'multiple' => true,
                'data_class' => null,
            ))
            //   ->add('photo',ImageType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $files = $data['files'];

            $fileService = $this->get('file_upload');
            $fileService->setFiles($files);


            $fileService->upload($immobilier);
            $mesImages = $fileService->getImages();

            if (null !== $mesImages) {
                foreach ($mesImages as $img) {
                    $em->persist($img);
                }
            }
            $em->flush();


            return $this->redirectToRoute('imageimmobilier_show', array('id' => $immobilier->getImmobilierId()));
        }

        return $this->render(':admin:immobiliers/gallery.html.twig', array(
            'immobilier' => $immobilier,
            'form' => $form->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Finds and displays a Immobilier entity.
     *
     * @Route("/Immobiliers/{id}/show", name="immobiliers_show")
     * @Method("GET")
     */
    public function showImmobiliersAction(Immobilier $immobilier)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        // $deleteForm = $this->createComptesDeleteForm($compte);

        $em = $this->getDoctrine()->getManager();

        $immobilier = $em->getRepository('AppBundle:Immobilier')->find($immobilier->getImmobilierId());
        //$role= $em->getRepository('AppBundle:Role')->findOneByCompte($compte);

        return $this->render(':admin:immobiliers/show.html.twig', array(
            'immobilier' => $immobilier,
            /*'delete_form' => $deleteForm->createView(),*/
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));


    }

    /**
     * Displays a form to edit an existing Immobilier entity.
     *
     * @Route("/Immobiliers/{id}/edit", name="immobiliers_edit")
     * @Method({"GET", "POST"})
     */
    public function editImmobiliersAction(Request $request, Immobilier $immobilier)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createImmobiliersDeleteForm($immobilier);
        $editForm = $this->createForm('AppBundle\Form\ImmobilierType', $immobilier);
        //$editForm->handleRequest($request);
        $edform = $this->createFormBuilder()
            ->add('ville', EntityType::class, array(
                'class' => 'AppBundle:Ville',
                'choice_label' => 'villeNom', 'label' => 'Nom Utilisateur :', 'label_attr' => array('class' => 'control-label ')
            ))
            ->getForm();
        $editForm->handleRequest($request);
        $formfiles = $this->createFormBuilder()
            ->add('files', FileType::class)
            //  ->add('save', SubmitType::class, array('label' => 'Telecharger', 'attr' => array('class' => 'btn btn-primary right', 'style' => 'margin-top: 12px;')))
            ->getForm();
        $formfiles->handleRequest($request);

        if ($editForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            if ($request->request->has('mon_quartier')) {
                $em = $this->getDoctrine()->getManager();
                $quarterId = intval($request->request->get('mon_quartier'));
                $quarter = $em->getRepository('AppBundle:Quartier')
                    ->find($quarterId);
                $immobilier->setQuartier($quarter);
                // $em->clear('AppBundle:Quartier');
            }
            $em->merge($immobilier);
            $em->flush();

            $notif = new Notification();
            $notif->setCompte($user);
            $notif->setDateNotification(new \DateTime());
            $notif->setIdEntity($immobilier->getImmobilierId());
            $em->persist($notif);

            $profilNotif = new ProfilNotification();
            $profilNotif->setCompte($immobilier->getProprietaire()->getCompte());
            $profilNotif->setActive(true);

            $profilNotif->setNotification($notif);
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(4));

            $em->persist($profilNotif);

            $em->flush();

            return $this->redirectToRoute('immobiliers_index', array('id' => $immobilier->getImmobilierId()));
        }

        return $this->render(':admin:immobiliers/edit.html.twig', array(
            'immobilier' => $immobilier,
            'edit_form' => $editForm->createView(),
            'edform' => $edform->createView(),
            'formfiles' => $formfiles->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }


    /**
     * Deletes a Immobilier entity.
     *
     * @Route("/Immobiliers/{id}/delete", name="immobiliers_delete")
     * @Method({"GET", "POST"})
     *
     */
    public
    function deleteImmobiliersAction(Request $request, Immobilier $immobilier)
    {
        $editForm = $this->createForm('AppBundle\Form\ImmobilierType', $immobilier);
        $editForm->handleRequest($request);


        $em = $this->getDoctrine()->getManager();
        if ($immobilier->isEtat() == true) {
            $immobilier->setEtat(false);
        } else {
            $immobilier->setEtat(true);
        }
        $em->merge($immobilier);
        $em->flush();


        return $this->redirectToRoute('immobiliers_index');
    }

    /**
     * Creates a form to delete a Immobilier entity.
     *
     * @param Immobilier $immobilier The Immobilier entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private
    function createImmobiliersDeleteForm(Immobilier $immobilier)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('immobiliers_delete', array('id' => $immobilier->getImmobilierId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Deletes a Image entity.
     *
     * @Route("/Image/{id}/delete", name="imagee_delete")
     * @Method({"GET", "POST"})
     */
    public
    function deleteImageAction(Request $request, Image $image)
    {
        /*$form = $this->createImageDeleteForm($image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {*/
        $id = $image->getImmobilier()->getImmobilierId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();
        return $this->redirectToRoute('imageimmobilier_show', array('id' => $id));
        /* }*/


    }

//*******************************************************************************************************
    /**
     * Finds and displays a Compte entity.
     *
     * @Route("/Immobilier/{id}/Photo", name="imageimmobilier_show")
     * @Method({"GET", "POST"})
     */
    public
    function showImageImmobilierAction(Request $request, Immobilier $immobilier)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createImmobiliersDeleteForm($immobilier);
        $form = $this->createFormBuilder()
            ->add('files', FileType::class, array(
                'multiple' => true,
                'data_class' => null,
            ))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $files = $data['files'];

            $fileService = $this->get('file_upload');
            $fileService->setFiles($files);


            $fileService->upload($immobilier);
            $mesImages = $fileService->getImages();

            if (null !== $mesImages) {
                foreach ($mesImages as $img) {

                    $em->persist($img);

                }
            }
            $em->flush();


            return $this->redirectToRoute('imageimmobilier_show', array('id' => $immobilier->getImmobilierId()));
        }
        $em = $this->getDoctrine()->getManager();

        $imgs = $em->getRepository('AppBundle:Image')->findByImmobilier($immobilier);
        //$role= $em->getRepository('AppBundle:Role')->findOneByCompte($compte);
        $img = $this->get('knp_paginator')->paginate($imgs, $request->query->getInt('page', 1), 8);
        return $this->render(':admin:immobiliers/gallery.html.twig', array(
            'immobilier' => $immobilier,
            'img' => $img,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing Image entity.
     *
     * @Route("/Images/{id}/edit", name="imagess_edit")
     * @Method({"GET", "POST"})
     */
    public
    function editImagesAction(Request $request, $id)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $form = $this->createFormBuilder()
            ->add('files', FileType::class, array(
                'multiple' => true,
                'data_class' => null,
            ))
            ->getForm();
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('AppBundle:Image')->find($id);
        $imgss = $em->getRepository('AppBundle:Image')->findAll();
        foreach ($imgss as $i) {
            if ($image->getImmobilier() == $i->getImmobilier()) {
                $i->setBienActive(false);
                $em->flush();
            }
        }

        if ($image->isBienActive() != true) {

            $image->setBienActive(true);
            $imo = $image->getImmobilier();
            $imo->setMainImage($image->getUrl());
            $em->merge($imo);
            $em->flush();
        }
        $em->merge($image);
        $em->flush();
        $immobilier = $image->getImmobilier();
        $imgs = $em->getRepository('AppBundle:Image')->findByImmobilier($immobilier);
        //$role= $em->getRepository('AppBundle:Role')->findOneByCompte($compte);
        $img = $this->get('knp_paginator')->paginate($imgs, $request->query->getInt('page', 1), 8);

        return $this->render(':admin:immobiliers/gallery.html.twig', array(
            'immobilier' => $immobilier,
            'img' => $img,
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

//**********************************************Annonce***************************************************
    /**
     * Lists all Annonce entities.
     *
     * @Route("/Annoncee/", name="annoncee_index")
     * @Method("GET")
     */
    public
    function indexAnnonceeAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $profilNotifs = $em->getRepository('AppBundle:ProfilNotification')->findby(array('active' => true));
        $typeNotifications = $em->getRepository('AppBundle:TypeNotification')->findby(array('entite' => 'Annonce'));
        foreach ($profilNotifs as $profilNotif) {
            foreach ($typeNotifications as $typeNotification) {
                if ($profilNotif->getTypeNotification() == $typeNotification) {
                    $profilNotif->setActive(false);
                    $em->merge($profilNotif);
                    $em->flush();
                }
            }
        }
        $annonces_location = $em->getRepository('AppBundle:Annonce')->findby(array('typeAnnonce' => 'Location'), array('datePublication' => 'DESC'));
        $annonces_vente = $em->getRepository('AppBundle:Annonce')->findby(array('typeAnnonce' => 'Vente'), array('datePublication' => 'DESC'));
        $paginator1 = $this->get('knp_paginator');
        $pagination_location = $paginator1->paginate($annonces_location, $request->query->getInt('page', 1), 5);
        $paginator2 = $this->get('knp_paginator');
        $pagination_vente = $paginator2->paginate($annonces_vente, $request->query->getInt('page', 1), 5);
        return $this->render(':admin:annoncee/index.html.twig', array(
            'pagination_location' => $pagination_location,
            'pagination_vente' => $pagination_vente,
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }
    /**
     * Creates a new Annonce entity.
     *
     * @Route("/Annoncee/new", name="annoncee_new")
     * @Method({"GET", "POST"})
     */
    public
    function newAnnonceeAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $annonce = new Annonce();

        $form = $this->createForm('AppBundle\Form\AnnonceType', $annonce)->add('immobilier', ImmobilierType::class)
        ;
        $form->handleRequest($request);
        $formville = $this->createFormBuilder()
            ->add('ville',
                EntityType::class, array(
                    'class' => 'AppBundle:Ville',
                    'placeholder' => 'Selectionne une Ville !',
                    'label'=>'Ville :',
                    'label_attr'=>array('class'=>'control-label '), 'attr' => array('class' => 'form-control')))
            ->getForm();
        $formville->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $immobilier1 = $form['immobilier']->getData();

            if ($request->request->has('mon_quartier')) {
                $quarterId = intval($request->request->get('mon_quartier'));
                $quarter = $em->getRepository('AppBundle:Quartier')
                    ->find($quarterId);
                $immobilier1->setQuartier($quarter);
            }

            $annonce->setStatutDepot('En Attente');
            $annonce->setEtat('En Attente');
            $annonce->setDateDepot(new \DateTime('now'));
            if ($annonce->getTypeAnnonce() == 'Location') {
                $annonce->setCommission(100);
                $i = $annonce->getPrixDelai() * ($annonce->getCommission() / 100);
                $annonce->setMontant($i + ($annonce->getPrixDelai() * 2));
                $annonce->setCommission($i);
            }
            if ($annonce->getTypeAnnonce() == 'Vente') {
                $annonce->setCommission(20);
                $i = $annonce->getPrixDelai() * ($annonce->getCommission() / 100);
                $annonce->setMontant($i + $annonce->getPrixDelai());
                $annonce->setCommission($i);
            }
            $em->persist($annonce);
            $em->merge($immobilier1);
            $em->flush();

            $notif = new Notification();
            $notif->setCompte($user);
            $notif->setDateNotification(new \DateTime());
            $notif->setIdEntity($annonce->getAnnonceId());
            $em->persist($notif);

            $profilNotif = new ProfilNotification();
            $profilNotif->setCompte($annonce->getDepositaire()->getCompte());
            $profilNotif->setActive(true);

            $profilNotif->setNotification($notif);
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(1));

            $em->persist($profilNotif);

            $em->flush();
            return $this->redirectToRoute('annoncee_index', array('id' => $annonce->getAnnonceId()));
        }

        return $this->render(':admin:annoncee/new.html.twig', array(
            'annonce' => $annonce,
            'formville'=>$formville->createView(),
            'form' => $form->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }


    /**
     * Finds and displays a Annonce entity.
     *
     * @Route("/Annoncee/{id}", name="annoncee_show")
     * @Method("GET")
     */
    public
    function showAnnonceeAction(Annonce $annonce)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createAnnonceeDeleteForm($annonce);
        $em = $this->getDoctrine()->getManager();
        $annonces_postulation = $em->getRepository('AppBundle:Postuler')->findByAnnonce($annonce);
        return $this->render(':admin:annoncee/show.html.twig', array(
            'annonces_postulation' => count($annonces_postulation),
            'annonce' => $annonce,
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing Annonce entity.
     *
     * @Route("/Annoncee/{id}/edit", name="annoncee_edit")
     * @Method({"GET", "POST"})
     */
    public
    function editAnnonceeAction(Request $request, Annonce $annonce)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createAnnonceeDeleteForm($annonce);
        $editForm = $this->createForm('AppBundle\Form\AnnonceType', $annonce)->add('immobilier', EntityType::class, array(
            'class' => 'AppBundle:Immobilier', 'label' => 'Intituler du Bien :', 'label_attr' => array('class' => 'control-label '), 'attr' => array('class' => 'form-control m-bot15')
        ));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            if ($annonce->getTypeAnnonce() == 'Location') {
                $annonce->setCommission(100);
                $i = $annonce->getPrixDelai() * ($annonce->getCommission() / 100);
                $annonce->setMontant($i + ($annonce->getPrixDelai() * 2));
                $annonce->setCommission($i);
            }
            if ($annonce->getTypeAnnonce() == 'Vente') {
                $annonce->setCommission(20);
                $i = $annonce->getPrixDelai() * ($annonce->getCommission() / 100);
                $annonce->setMontant($i + $annonce->getPrixDelai());
                $annonce->setCommission($i);

            }

            $em->merge($annonce);
            $em->flush();

            $notif = new Notification();
            $notif->setCompte($user);
            $notif->setDateNotification(new \DateTime());
            $notif->setIdEntity($annonce->getAnnonceId());
            $em->persist($notif);

            $profilNotif = new ProfilNotification();
            $profilNotif->setCompte($annonce->getDepositaire()->getCompte());
            $profilNotif->setActive(true);

            $profilNotif->setNotification($notif);
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(2));

            $em->persist($profilNotif);

            $em->flush();
            return $this->redirectToRoute('annoncee_index');
        }
        return $this->render(':admin:annoncee/edit.html.twig', array(
            'annonce' => $annonce,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Deletes a Annonce entity.
     *
     * @Route("/Annoncee/{id}/Activations", name="annoncee_delete")
     */
    public
    function deleteAnnonceeAction(Request $request, Annonce $annonce)
    {
        /* $form = $this->createAnnonceeDeleteForm($annonce);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {*/
        $em = $this->getDoctrine()->getManager();
        $annonce->setStatutDepot("Desactiver");
        $em->merge($annonce);
        $em->flush();
        /* }*/

        return $this->redirectToRoute('annoncee_index');
    }

    /**
     * Creates a form to delete a Annonce entity.
     *
     * @param Annonce $annonce The Annonce entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private
    function createAnnonceeDeleteForm(Annonce $annonce)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annoncee_delete', array('id' => $annonce->getAnnonceId())))
            ->setMethod('DELETE')
            ->getForm();
    }

//*******************************************************************************************************
//**********************************************Agence***************************************************
    /**
     * Lists all Agence entities.
     *
     * @Route("/agencee/", name="agencee_index")
     * @Method("GET")
     */
    public
    function indexAgenceeAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $profilNotifs = $em->getRepository('AppBundle:ProfilNotification')->findby(array('active' => true));
        $typeNotifications = $em->getRepository('AppBundle:TypeNotification')->findby(array('entite' => 'Agence'));
        foreach ($profilNotifs as $profilNotif) {
            foreach ($typeNotifications as $typeNotification) {
                if ($profilNotif->getTypeNotification() == $typeNotification) {
                    $profilNotif->setActive(false);
                    $em->merge($profilNotif);
                    $em->flush();
                }
            }
        }
        $agences = $em->getRepository('AppBundle:Agence')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($agences, $request->query->getInt('page', 1), 5);
        return $this->render(':admin:agence/index.html.twig', array('pagination' => $pagination,
            'agences' => $agences, 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Creates a new Agence entity.
     *
     * @Route("/agencee/new", name="agencee_new")
     * @Method({"GET", "POST"})
     */
    public
    function newAgenceeAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $agence = new Agence();
        $form = $this->createForm('AppBundle\Form\AgenceType', $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agence);
            $em->flush();

            $notif = new Notification();
            $notif->setCompte($user);
            $notif->setDateNotification(new \DateTime());
            $notif->setIdEntity($agence->getAgenceId());
            $em->persist($notif);

            $profilNotif = new ProfilNotification();
            $profilNotif->setCompte($user);
            $profilNotif->setActive(true);
            $profilNotif->setNotification($notif);
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(19));
            $em->persist($profilNotif);
            $em->flush();
            return $this->redirectToRoute('agencee_show', array('id' => $agence->getAgenceId()));
        }

        return $this->render(':admin:agence/new.html.twig', array(
            'agence' => $agence,
            'form' => $form->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Finds and displays a Agence entity.
     *
     * @Route("/agencee/{id}/show", name="agencee_show")
     * @Method("GET")
     */
    public
    function showAgenceeAction(Agence $agence)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createAgenceeDeleteForm($agence);

        return $this->render(':admin:agence/show.html.twig', array(
            'agence' => $agence,
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing Agence entity.
     *
     * @Route("/agencee/{id}/edit", name="agencee_edit")
     * @Method({"GET", "POST"})
     */
    public
    function editAgenceeAction(Request $request, Agence $agence)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createAgenceeDeleteForm($agence);
        $editForm = $this->createForm('AppBundle\Form\AgenceType', $agence);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agence);
            $em->flush();

            $notif = new Notification();
            $notif->setCompte($user);
            $notif->setDateNotification(new \DateTime());
            $notif->setIdEntity($agence->getAgenceId());
            $em->persist($notif);

            $profilNotif = new ProfilNotification();
            $profilNotif->setCompte($user);
            $profilNotif->setActive(true);
            $profilNotif->setNotification($notif);
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(20));
            $em->persist($profilNotif);
            $em->flush();
            return $this->redirectToRoute('agencee_index', array('id' => $agence->getAgenceId()));
        }

        return $this->render(':admin:agence/edit.html.twig', array(
            'agence' => $agence,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Deletes a Agence entity.
     *
     * @Route("/agencee/{id}/delete", name="agencee_delete")
     * @Method({"GET", "POST"})
     */
    public
    function deleteAgenceeAction(Request $request, Agence $agence)
    {
        $form = $this->createAgenceeDeleteForm($agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($agence);
            $em->flush();
        }

        return $this->redirectToRoute('agencee_index');
    }

    /**
     * Creates a form to delete a Agence entity.
     *
     * @param Agence $agence The Agence entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private
    function createAgenceeDeleteForm(Agence $agence)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('agencee_delete', array('id' => $agence->getAgenceId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Creates a new Immobilier entity.
     *
     * @Route("/agencee/photo", name="agencee_newphoto")
     * @Method({"GET", "POST"})
     */
    public
    function newPhotoagenceeAction(Request $request, Agence $agence)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $form = $this->createFormBuilder()
            ->add('files', FileType::class, array(
                'label' => 'Image(s) du Bien :', 'label_attr' => array('class' => 'control-label col-lg-6'),
                'multiple' => true,
                'data_class' => null,
            ))
            ->getForm();
        $form->handleRequest($request);
        /*  var_dump($user);
          die();*/
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $files = $data['files'];

            $fileService = $this->get('file_upload');
            $fileService->setFiles($files);


            $fileService->upload1($agence);
            $mesImages = $fileService->getImages();

            if (null !== $mesImages) {
                foreach ($mesImages as $img) {
                    $em->persist($img);

                }
            }
            $em->flush();


            return $this->redirectToRoute('imageagencee_show', array('id' => $agence->getAgenceId()));
        }
        $em = $this->getDoctrine()->getManager();

        $imgs = $em->getRepository('AppBundle:Image')->findByAgence($agence);
        //$role= $em->getRepository('AppBundle:Role')->findOneByCompte($compte);
        $img = $this->get('knp_paginator')->paginate($imgs, $request->query->getInt('page', 1), 8);
        return $this->render(':admin:agence/gallery.html.twig', array(
            'agence' => $agence,
            'img' => $img,
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user

        ));
    }

    /**
     * Finds and displays a Compte entity.
     *
     * @Route("/agencee/{id}/Photo", name="imageagencee_show")
     * @Method({"GET", "POST"})
     */
    public
    function showImageagenceeAction(Request $request, Agence $agence)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createAgenceeDeleteForm($agence);
        $form = $this->createFormBuilder()
            ->add('files', FileType::class, array(
                'multiple' => true,
                'data_class' => null,
            ))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $files = $data['files'];
            $fileService = $this->get('file_upload');
            $fileService->setFiles($files);


            $fileService->upload1($agence);

            $mesImages = $fileService->getImages();

            if (null !== $mesImages) {
                foreach ($mesImages as $img) {

                    $em->persist($img);

                }
            }
            $em->flush();


            return $this->redirectToRoute('imageagencee_show', array('id' => $agence->getAgenceId()));
        }
        $em = $this->getDoctrine()->getManager();

        $imgs = $em->getRepository('AppBundle:Image')->findByAgence($agence);
        //$role= $em->getRepository('AppBundle:Role')->findOneByCompte($compte);
        $img = $this->get('knp_paginator')->paginate($imgs, $request->query->getInt('page', 1), 8);
        return $this->render(':admin:agence/gallery.html.twig', array(
            'agence' => $agence,
            'img' => $img,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing Image entity.
     *
     * @Route("/Imagess/{id}/edit", name="imagesAgence_edit")
     * @Method({"GET", "POST"})
     */
    public
    function editImagessAction(Request $request, $id)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $form = $this->createFormBuilder()
            ->add('files', FileType::class, array(
                'multiple' => true,
                'data_class' => null,
            ))
            ->getForm();
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('AppBundle:Image')->find($id);
        $imgss = $em->getRepository('AppBundle:Image')->findAll();
        foreach ($imgss as $i) {
            if ($image->getAgence() == $i->getAgence()) {
                $i->setAgenceActive(false);
                $em->flush();
            }
        }

        if ($image->isAgenceActive() != true) {

            $image->setAgenceActive(true);

        }

        $em->merge($image);
        $em->flush();
        $agence = $image->getAgence();
        $agence->setLogo($image->getUrl());
        $em->merge($agence);
        $em->flush();
        $imgs = $em->getRepository('AppBundle:Image')->findByAgence($agence);
        //$role= $em->getRepository('AppBundle:Role')->findOneByCompte($compte);
        $img = $this->get('knp_paginator')->paginate($imgs, $request->query->getInt('page', 1), 8);

        return $this->render(':admin:agence/gallery.html.twig', array(
            'agence' => $agence,
            'img' => $img,
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Deletes a Image entity.
     *
     * @Route("/Imagess/{id}/delete", name="imageAgence_delete")
     * @Method({"GET", "POST"})
     */
    public
    function deleteImagessAction(Request $request, Image $image)
    {
        /*$form = $this->createImageDeleteForm($image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {*/
        $id = $image->getAgence()->getAgenceId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();
        return $this->redirectToRoute('imageagencee_show', array('id' => $id));
        /* }*/


    }

//*******************************************************************************************************
//**********************************************Paiement***************************************************
    /**
     * Lists all Paiement entities.
     *
     * @Route("/Reservations/Paiements/{id}", name="paiement_index")
     * @Method({"GET", "POST"})
     */
    public
    function indexPaiementAction(Request $request, $id)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $profilNotifs = $em->getRepository('AppBundle:ProfilNotification')->findby(array('active' => true));
        $typeNotifications = $em->getRepository('AppBundle:TypeNotification')->findby(array('entite' => 'Paiement'));
        foreach ($profilNotifs as $profilNotif) {
            foreach ($typeNotifications as $typeNotification) {
                if ($profilNotif->getTypeNotification() == $typeNotification) {
                    $profilNotif->setActive(false);
                    $em->merge($profilNotif);
                    $em->flush();
                }
            }
        }
        $paiements = $em->getRepository('AppBundle:Paiement')->findAll();
        $em = $this->getDoctrine()->getManager();
        $reservationss = $em->getRepository('AppBundle:Reservation')->find($id);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($reservationss, $request->query->getInt('page', 1), 5);
        return $this->render(':admin:paiement/index.html.twig', array('pagination' => $pagination,
            'reservation' => $reservationss,
            'paiements' => $paiements, 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Creates a new Paiement entity.
     *
     * @Route("/Reservations/Paiements/new", name="paiement_new")
     * @Method({"GET", "POST"})
     */
    public
    function newPaiementAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $paiement = new Paiement();

        $form = $this->createForm('AppBundle\Form\PaiementType', $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($paiement->getReservation()->getPostuler()->getPostMontant() < $paiement->getReservation()->getMontant() && $paiement->getReservation()->getPostuler()->getStatut() == 'Validation') {


                $paiement->setDatePaiement(new \DateTime('now'));

                //  $i = $annonce->getMontant() * ($annonce->getCommission() / 100);
                // inverse $annonce->getCommission()*(100/$annonce->getMontant());
                // $annonce->setCommission($i);
                $em->persist($paiement);

                $em->flush();
                $reservation = $paiement->getReservation();
                $reservation->setMontant($reservation->getMontant() + $paiement->getMontant());
                if ($paiement->getReservation()->getPostuler()->getPostMontant() == $paiement->getReservation()->getMontant()) {

                }
            }

            return $this->redirectToRoute('paiement_index', array('id' => $paiement->getPaiementId()));
        }

        return $this->render(':admin:Paiement/new.html.twig', array(

            'paiement' => $paiement,
            'form' => $form->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }


    /**
     * Finds and displays a Paiement entity.
     *
     * @Route("/Reservations/Paiements/{id}", name="paiement_show")
     * @Method("GET")
     */
    public
    function showPaiementAction(Paiement $paiement)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createPaiementDeleteForm($paiement);

        return $this->render(':admin:paiement/show.html.twig', array(
            'paiement' => $paiement,
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing Paiement entity.
     *
     * @Route("/Reservations/Paiements/{id}/edit", name="paiement_edit")
     * @Method({"GET", "POST"})
     */
    public
    function editPaiementAction(Request $request, Paiement $paiement)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createPaiementDeleteForm($paiement);
        $editForm = $this->createForm('AppBundle\Form\PaiementType', $paiement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paiement);
            $em->flush();

            return $this->redirectToRoute('paiement_index', array('id' => $paiement->getPaiementId()));
        }

        return $this->render(':admin:paiement/edit.html.twig', array(
            'paiement' => $paiement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Deletes a Paiement entity.
     *
     * @Route("/Reservations/Paiements/{id}", name="paiement_delete")
     * @Method("DELETE")
     */
    public
    function deletePaiementAction(Request $request, Paiement $paiement)
    {
        $form = $this->createPaiementDeleteForm($paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($paiement);
            $em->flush();
        }

        return $this->redirectToRoute('paiement_index');
    }

    /**
     * Creates a form to delete a Paiement entity.
     *
     * @param Paiement $paiement The Paiement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private
    function createPaiementDeleteForm(Paiement $paiement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annoncee_delete', array('id' => $paiement->getPaiementId())))
            ->setMethod('DELETE')
            ->getForm();
    }

//*******************************************************************************************************
//**********************************************Reservation***************************************************
    /**
     * Lists all Reservation entities.
     *
     * @Route("/Reservations/", name="reservation_index")
     * @Method("GET")
     */
    public
    function indexReservationAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $profilNotifs = $em->getRepository('AppBundle:ProfilNotification')->findby(array('active' => true));
        $typeNotifications = $em->getRepository('AppBundle:TypeNotification')->findby(array('entite' => 'Reservation'));
        foreach ($profilNotifs as $profilNotif) {
            foreach ($typeNotifications as $typeNotification) {
                if ($profilNotif->getTypeNotification() == $typeNotification) {
                    $profilNotif->setActive(false);
                    $em->merge($profilNotif);
                    $em->flush();
                }
            }
        }
        //  $reservations = $em->getRepository('AppBundle:Reservation')->findAlll();
        $reservations = $em->getRepository('AppBundle:Reservation')->findAlll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($reservations, $request->query->getInt('page', 1), 5);


        return $this->render(':admin:reservation/index.html.twig', array('pagination' => $pagination,
            'reservations' => $reservations,

            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Creates a new Reservation entity.
     *
     * @Route("/Reservations/new", name="reservation_new")
     * @Method({"GET", "POST"})
     */
    public
    function newReservationAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $reservation = new Reservation();

        $form = $this->createForm('AppBundle\Form\ReservationType', $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $postuler = new Postuler();
            $postuler->setDatePost(new \DateTime('now'));
            $postuler->setPersonne($reservation->getPostuler()->getPersonne());
            $postuler->setAnnonce($reservation->getPostuler()->getAnnonce());
            $postuler->setPostMontant($reservation->getPostuler()->getAnnonce()->getMontant());
            $postuler->setStatut('En Attente');
            $em->persist($postuler);
            $em->flush();
            $reservation->setPostuler($postuler);
            $reservation->setMontant($postuler->getPostMontant());
            $reservation->setDateReservation(new \DateTime('now'));
            $em->persist($reservation);
            $em->flush();

            $notif = new Notification();
            $notif->setCompte($user);
            $notif->setDateNotification(new \DateTime());
            $notif->setIdEntity($reservation->getReservationId());
            $em->persist($notif);

            $profilNotif = new ProfilNotification();
            $profilNotif->setCompte($reservation->getPostuler()->getPersonne()->getCompte());
            $profilNotif->setActive(true);
            $profilNotif->setNotification($notif);
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(21));
            $em->persist($profilNotif);
            $em->flush();
            return $this->redirectToRoute('reservation_index', array('id' => $reservation->getReservationId()));
        }

        return $this->render(':admin:reservation/new.html.twig', array(
            'reservation' => $reservation,
            'form' => $form->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }


    /**
     * Finds and displays a Reservation entity.
     *
     * @Route("/Reservations/{id}", name="reservation_show")
     * @Method("GET")
     */
    public
    function showReservationAction(Reservation $reservation)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createReservationDeleteForm($reservation);

        return $this->render(':admin:reservation/show.html.twig', array(
            'reservation' => $reservation,
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing Reservation entity.
     *
     * @Route("/Reservations/{id}/edit", name="reservation_edit")
     * @Method({"GET", "POST"})
     */
    public
    function editReservationAction(Request $request, Reservation $reservation)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createReservationDeleteForm($reservation);
        $editForm = $this->createForm('AppBundle\Form\ReservationType', $reservation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            $notif = new Notification();
            $notif->setCompte($user);
            $notif->setDateNotification(new \DateTime());
            $notif->setIdEntity($reservation->getReservationId());
            $em->persist($notif);

            $profilNotif = new ProfilNotification();
            $profilNotif->setCompte($reservation->getPostuler()->getPersonne()->getCompte());
            $profilNotif->setActive(true);
            $profilNotif->setNotification($notif);
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(22));
            $em->persist($profilNotif);
            $em->flush();
            return $this->redirectToRoute('reservation_edit', array('id' => $reservation->getReservationId()));
        }

        return $this->render(':admin:reservation/edit.html.twig', array(
            'reservation' => $reservation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Deletes a Reservation entity.
     *
     * @Route("/Reservations/{id}", name="reservation_delete")
     * @Method("DELETE")
     */
    public
    function deleteReservationAction(Request $request, Reservation $reservation)
    {
        $form = $this->createReservationDeleteForm($reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }

    /**
     * Creates a form to delete a Reservation entity.
     *
     * @param Reservation $reservation The Reservation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private
    function createReservationDeleteForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_delete', array('id' => $reservation->getReservationId())))
            ->setMethod('DELETE')
            ->getForm();
    }

//*******************************************************************************************************

//**********************************************Postuler***************************************************
    /**
     * Lists all Reservation entities.
     *
     * @Route("/Postulers/", name="postuler_index")
     * @Method("GET")
     */
    public
    function indexPostulerAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $profilNotifs = $em->getRepository('AppBundle:ProfilNotification')->findby(array('active' => true));
        $typeNotifications = $em->getRepository('AppBundle:TypeNotification')->findby(array('entite' => 'Postuler'));
        foreach ($profilNotifs as $profilNotif) {
            foreach ($typeNotifications as $typeNotification) {
                if ($profilNotif->getTypeNotification() == $typeNotification) {
                    $profilNotif->setActive(false);
                    $em->merge($profilNotif);
                    $em->flush();
                }
            }
        }
        $postuler = $em->getRepository('AppBundle:Postuler')->findBy(array('statut' => 'En Attente'), array('datePost' => 'DESC'));


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($postuler, $request->query->getInt('page', 1), 5);


        return $this->render(':admin:postuler/index.html.twig', array('pagination' => $pagination,

            'postulers' => $postuler,
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Lists all archives Postulation entities.
     *
     * @Route("/Postulers/archives", name="postuler_archive")
     * @Method("GET")
     */
    public
    function archivePostulerAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $profilNotifs = $em->getRepository('AppBundle:ProfilNotification')->findby(array('active' => true));
        $typeNotifications = $em->getRepository('AppBundle:TypeNotification')->findby(array('entite' => 'Postuler_archive'));
        foreach ($profilNotifs as $profilNotif) {
            foreach ($typeNotifications as $typeNotification) {
                if ($profilNotif->getTypeNotification() == $typeNotification) {
                    $profilNotif->setActive(false);
                    $em->merge($profilNotif);
                    $em->flush();
                }
            }
        }
        $postuler = $em->getRepository('AppBundle:Postuler')->findBy(array('statut' => 'Annuler'), array('datePost' => 'DESC'));


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($postuler, $request->query->getInt('page', 1), 5);


        return $this->render(':admin:postuler/archive.html.twig', array('pagination' => $pagination,

            'postulers' => $postuler,
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Creates a new Reservation entity.
     *
     * @Route("/Postulers/new", name="postuler_new")
     * @Method({"GET", "POST"})
     */
    public
    function newPostulersAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $postuler = new Postuler();

        $form = $this->createForm('AppBundle\Form\PostulerType', $postuler);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            $postuler1 = $em->getRepository('AppBundle:Postuler')->findby(array('annonce' => $postuler->getAnnonce(), 'personne' => $postuler->getPersonne()), array('datePost' => 'DESC'));
            if (!$postuler1) {
                $em = $this->getDoctrine()->getManager();

                $postuler->setDatePost(new \DateTime('now'));


                $postuler->setPostMontant($postuler->getAnnonce()->getPrixDelai() * 3);
                $postuler->setStatut('En Attente');
                $em->persist($postuler);
                $em->flush();
            }
            $notif = new Notification();
            $notif->setCompte($user);
            $notif->setDateNotification(new \DateTime());
            $notif->setIdEntity($postuler->getPostId());
            $em->persist($notif);

            $profilNotif = new ProfilNotification();
            $profilNotif->setCompte($postuler->getPersonne()->getCompte());
            $profilNotif->setActive(true);
            $profilNotif->setNotification($notif);
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(5));
            $em->persist($profilNotif);
            $em->flush();
            return $this->redirectToRoute('postuler_index');
        }

        return $this->render(':admin:postuler/new.html.twig', array(
            'reservation' => $postuler,
            'form' => $form->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }


    /**
     * Finds and displays a Postuler entity.
     *
     * @Route("/Postulers/{id}", name="postuler_show")
     * @Method("GET")
     */
    public
    function showPostulersAction(Postuler $postuler)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createPostulersDeleteForm($postuler);
        $typedelai = $postuler->getAnnonce()->isTypeDelai();
        return $this->render(':admin:postuler/show.html.twig', array(
            'typedelai' => $typedelai,
            'postuler' => $postuler,
            'delete_form' => $deleteForm->createView(), 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing Reservation entity.
     *
     * @Route("/Postulers/{id}/edit", name="postuler_edit")
     * @Method({"GET", "POST"})
     */
    public
    function editPostulersAction(Request $request, Postuler $postuler)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $editForm = $this->createForm('AppBundle\Form\PostulerType', $postuler)
            ->add('Modifier', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-danger'),
                    'label' => 'Modifier')
            )
            ->add('Annuler', ResetType::class, array('attr' => array('class' => 'btn btn-warning'),
                    'label' => 'Annuler')
            );
        $editForm->handleRequest($request);

        $edform = $this->createFormBuilder()
            ->add('personne', EntityType::class, array(
                'class' => 'AppBundle:Personne',
                'choice_label' => 'nom', 'label' => 'Nom Utilisateur :', 'label_attr' => array('class' => 'control-label ')
            ))
            ->add('annonce', EntityType::class, array(
                'class' => 'AppBundle:Annonce',
                'choice_label' => 'titre', 'label' => 'Titre Annonce :', 'label_attr' => array('class' => 'control-label ')
            ))
            ->getForm();
        $edform->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        if ($editForm->isSubmitted()) {
            if ($request->request->has('mon_annonce')) {


                $annonceId = intval($request->request->get('mon_annonce'));
                $annonce = $em->getRepository('AppBundle:Annonce')
                    ->find($annonceId);
                $postuler->setAnnonce($annonce);
                $postuler->setPersonne($annonce->getDepositaire());
                $em->merge($postuler);
                $em->flush();
            }
            $notif = new Notification();
            $notif->setCompte($user);
            $notif->setDateNotification(new \DateTime());
            $notif->setIdEntity($postuler->getPostId());
            $em->persist($notif);

            $profilNotif = new ProfilNotification();
            $profilNotif->setCompte($postuler->getPersonne()->getCompte());
            $profilNotif->setActive(true);
            $profilNotif->setNotification($notif);
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(6));
            $em->persist($profilNotif);
            $em->flush();
            return $this->redirectToRoute('postuler_index');
        }

        return $this->render(':admin:postuler/edit.html.twig', array(
            'edform' => $edform->createView(),
            'postuler' => $postuler,
            'edit_form' => $editForm->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Deletes a Postuler entity.
     *
     * @Route("/Postulers/{id}/desactiver", name="postuler_delete")
     * @Method({"GET", "POST"})
     */
    public
    function deletePostulersAction(Request $request, Postuler $postuler)
    {
        $em = $this->getDoctrine()->getManager();
        $postuler = $em->getRepository('AppBundle:Postuler')->find($postuler->getPostId());
        if (!$postuler) {
            throw $this->createNotFoundException('No guest found for id ' . $postuler->getPostId());
        }
        $postuler->setStatut('Annuler');
        $em->merge($postuler);
        $em->flush();
        return $this->redirect($this->generateUrl('postuler_index'));
    }

    /**
     * Creates a form to delete a Postuler entity.
     *
     * @param Postuler $postuler The Postuler entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private
    function createPostulersDeleteForm(Postuler $postuler)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('postuler_delete', array('id' => $postuler->getPostId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Lists all Reservation entities.
     *
     * @Route("/Postulers/Annonce/{id}", name="postuler_annonce_index")
     * @Method("GET")
     */
    public
    function indexAnnoncePostulerAction(Request $request, Annonce $annonce)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $postuler = $em->getRepository('AppBundle:Postuler')->findBy(array('annonce' => $annonce), array('datePost' => 'DESC'));


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($postuler, $request->query->getInt('page', 1), 5);


        return $this->render(':admin/annoncee:postulation_annonce.html.twig', array('pagination' => $pagination,
            'annonce' => $annonce,
            'postulers' => $postuler,
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }
//*******************************************************************************************************


    /**
     * Finds and displays a Compte entity.
     *
     * @Route("/Comptes/{id}/Photo", name="imagecomptes_show")
     * @Method({"GET", "POST"})
     */
    public
    function showImageComptesAction(Request $request, Compte $compte)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $deleteForm = $this->createComptesDeleteForm($compte);
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);


        return $this->redirectToRoute('imagecomptes_show', array('id' => $compte->getCompteId(),

            'compte' => $compte,

            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));

    }

    /**
     * Lists all Annonce entities.
     *
     * @Route("/annoncee/", name="active_annonce")
     * @Method("GET")
     */
    public
    function indexActiveAnnoncesAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $profilNotifs = $em->getRepository('AppBundle:ProfilNotification')->findby(array('active' => true));
        $typeNotifications = $em->getRepository('AppBundle:TypeNotification')->findby(array('entite' => 'Annonce'));
        foreach ($profilNotifs as $profilNotif) {
            foreach ($typeNotifications as $typeNotification) {
                if ($profilNotif->getTypeNotification() == $typeNotification) {
                    $profilNotif->setActive(false);
                    $em->merge($profilNotif);
                    $em->flush();
                }
            }
        }
        $annonces = $em->getRepository('AppBundle:Annonce')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($annonces, $request->query->getInt('page', 1), 5);

        return $this->render(':admin/annoncee:active_annonce.html.twig', array('pagination' => $pagination,
            'annonces' => $annonces, 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Lists all Immobilier entities.
     *
     * @Route("/immobiliers/", name="active_Immobilier")
     * @Method("GET")
     */
    public
    function indexActiveImmobiliersAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $profilNotifs = $em->getRepository('AppBundle:ProfilNotification')->findby(array('active' => true));
        $typeNotifications = $em->getRepository('AppBundle:TypeNotification')->findby(array('entite' => 'immobilier'));
        foreach ($profilNotifs as $profilNotif) {
            foreach ($typeNotifications as $typeNotification) {
                if ($profilNotif->getTypeNotification() == $typeNotification) {
                    $profilNotif->setActive(false);
                    $em->merge($profilNotif);
                    $em->flush();
                }
            }
        }
        $biens = $em->getRepository('AppBundle:Immobilier')->findby(array(), array('reference' => 'ASC'));
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($biens, $request->query->getInt('page', 1), 5);
        return $this->render(':admin/immobiliers:active_bien.html.twig', array('pagination' => $pagination,
            'biens' => $biens, 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing Annonce entity.
     *
     * @Route("/Annoncee/{id}/Activation", name="annonce_activation")
     * @Method({"GET", "POST"})
     */
    public
    function activationAnnonceAction(Request $request, Annonce $annonce)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        //$deleteForm = $this->createComptesDeleteForm($compte);
        $editForm = $this->createForm('AppBundle\Form\AnnonceType', $annonce);

        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        if ($annonce->getStatutDepot() == "En Attente") {
            $annonce->setStatutDepot("Valider");
            $annonce->setDatePublication(new \DateTime('now'));
        } elseif ($annonce->getStatutDepot() == "Valider") {
            $annonce->setStatutDepot("Desactiver");
            $annonce->setDatePublication(new \DateTime('now'));
        } elseif ($annonce->getStatutDepot() == "Desactiver") {
            $annonce->setStatutDepot("Valider");
            $annonce->setDatePublication(new \DateTime('now'));
        }

        $em->merge($annonce);
        $em->flush();

        $notif = new Notification();
        $notif->setCompte($user);
        $notif->setDateNotification(new \DateTime());
        /*if ($annonce->getStatutDepot() == "En Attente") {*/
        $notif->setIdEntity($annonce->getAnnonceId());
        /* } elseif ($annonce->getStatutDepot() == "Valider") {
             $notif->setIdEntity("Desactivation Annonce");
         } elseif ($annonce->getStatutDepot() == "Desactiver") {
             $notif->setIdEntity("Activation Annonce");
         }*/

        $em->persist($notif);

        $profilNotif = new ProfilNotification();
        $profilNotif->setCompte($annonce->getDepositaire()->getCompte());
        $profilNotif->setActive(true);
        $profilNotif->setNotification($notif);
        if ($annonce->getStatutDepot() == "En Attente") {
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(15));
        } elseif ($annonce->getStatutDepot() == "Valider") {
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(16));
        } elseif ($annonce->getStatutDepot() == "Desactiver") {
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(15));
        }

        $em->persist($profilNotif);
        $em->flush();

        $annonces = $em->getRepository('AppBundle:Annonce')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($annonces, $request->query->getInt('page', 1), 5);

        return $this->render(':admin/annoncee:active_annonce.html.twig', array(

            'pagination' => $pagination,
            'annonces' => $annonces, 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing Annonce entity.
     *
     * @Route("/Annoncee/{id}/Validation", name="annonce_validation")
     * @Method({"GET", "POST"})
     */
    public
    function validationAnnonceAction(Request $request, Annonce $annonce)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        //$deleteForm = $this->createComptesDeleteForm($compte);
        $editForm = $this->createForm('AppBundle\Form\AnnonceType', $annonce);

        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($annonce->getEtat() == "En Attente") {
            $annonce->setEtat("Valider");
        } elseif ($annonce->getEtat() == "Valider") {
            $annonce->setEtat("Desactiver");
        } elseif ($annonce->getEtat() == "Desactiver") {
            $annonce->setEtat("Valider");
        }

        $em->merge($annonce);
        $em->flush();

        $notif = new Notification();
        $notif->setCompte($user);
        $notif->setDateNotification(new \DateTime());
        /*if ($annonce->getEtat() == "En Attente") {*/
        $notif->setIdEntity($annonce->getAnnonceId());
        /*} elseif ($annonce->getEtat() == "Valider") {
            $notif->setIdEntity("Desactivation Annonce");
        } elseif ($annonce->getEtat() == "Desactiver") {
            $notif->setIdEntity("Acceptation Annonce");
        }*/

        $em->persist($notif);

        $profilNotif = new ProfilNotification();
        $profilNotif->setCompte($annonce->getDepositaire()->getCompte());
        $profilNotif->setActive(true);
        $profilNotif->setNotification($notif);
        if ($annonce->getEtat() == "En Attente") {
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(13));
        } elseif ($annonce->getEtat() == "Valider") {
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(14));
        } elseif ($annonce->getEtat() == "Desactiver") {
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(13));
        }

        $em->persist($profilNotif);
        $em->flush();

        $annonces_location = $em->getRepository('AppBundle:Annonce')->findby(array('typeAnnonce' => 'Location'), array('datePublication' => 'DESC'));
        $annonces_vente = $em->getRepository('AppBundle:Annonce')->findby(array('typeAnnonce' => 'Vente'), array('datePublication' => 'DESC'));
        $paginator1 = $this->get('knp_paginator');
        $pagination_location = $paginator1->paginate($annonces_location, $request->query->getInt('page', 1), 5);
        $paginator2 = $this->get('knp_paginator');
        $pagination_vente = $paginator2->paginate($annonces_vente, $request->query->getInt('page', 1), 5);
        return $this->render(':admin:annoncee/index.html.twig', array(
            'pagination_location' => $pagination_location,
            'pagination_vente' => $pagination_vente,
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing Immobilier entity.
     *
     * @Route("/Immobiliers/{id}/Activation", name="immobilier_activation")
     * @Method({"GET", "POST"})
     */
    public
    function activationBienAction(Request $request, Immobilier $immobilier)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        //$deleteForm = $this->createComptesDeleteForm($compte);
        $editForm = $this->createForm('AppBundle\Form\ImmobilierType', $immobilier);
        $editForm->handleRequest($request);


        $em = $this->getDoctrine()->getManager();
        if ($immobilier->isEtat()) {
            $immobilier->setEtat(false);
            //  $immobilier->setDatePublication(new \DateTime('now'));
        } else {
            $immobilier->setEtat(true);
        }
        $em->merge($immobilier);
        $em->flush();

        $notif = new Notification();
        $notif->setCompte($user);
        $notif->setDateNotification(new \DateTime());
        /*if ($immobilier->isEtat()) {*/
        $notif->setIdEntity($immobilier->getImmobilierId());
        /*} else {
            $notif->setIdEntity("Acceptation Bien");
        }*/

        $em->persist($notif);

        $profilNotif = new ProfilNotification();
        $profilNotif->setCompte($immobilier->getProprietaire()->getCompte());
        $profilNotif->setActive(true);
        $profilNotif->setNotification($notif);
        if ($immobilier->isEtat()) {
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(17));
        } else {
            $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(18));
        }

        $em->persist($profilNotif);
        $em->flush();

        $immobiliers = $em->getRepository('AppBundle:Immobilier')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($immobiliers, $request->query->getInt('page', 1), 5);

        return $this->render(':admin/immobiliers:active_bien.html.twig', array('pagination' => $pagination,
            'immobiliers' => $immobiliers, 'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * Desactiver a Immobilier entity.
     *
     * @Route("/Immobiliers/{id}/deletes", name="immobilierss_delete")
     * @Method({"GET", "POST"})
     *
     */
    public
    function deleteImmobilierssAction(Request $request, Immobilier $immobilier)
    {
        $editForm = $this->createForm('AppBundle\Form\ImmobilierType', $immobilier);
        $editForm->handleRequest($request);


        $em = $this->getDoctrine()->getManager();
        if ($immobilier->isEtat() == true) {
            $immobilier->setEtat(false);
        } else {
            $immobilier->setEtat(true);
        }
        $em->merge($immobilier);
        $em->flush();


        return $this->redirectToRoute('active_Immobilier');
    }

    /**
     * @Route("/aannoncee/Validation/{id}", name="annonce_modification_validation")
     * @Method({"GET", "POST"})
     */
    public
    function annonceeeValidationAction(Request $request, Annonce $annonce)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $formedit = $this->get('form.factory')->createNamedBuilder('formedit')
            ->add('commission', TextType::class, array('label' => 'Commition (%):', 'label_attr' => array('class' => 'control-label '), 'attr' => array('class' => 'form-control', 'type' => 'text')))
            //->add('valider',SubmitType::class, array('label' => 'Valider', 'attr' => array('class' => 'form-control', 'type' => 'submit')))
            ->getForm();
        $formedit->handleRequest($request);

        if ($formedit->isSubmitted()) {
            /*var_dump($formedit);
            die();*/
            $em = $this->getDoctrine()->getManager();
            $annonce->setStatutDepot('Valider');
            $annonce->setCommission($formedit['commission']->getData());
            $em->merge($annonce);
            $em->flush();

            return $this->redirectToRoute('active_annonce');
        }
        $em = $this->getDoctrine()->getManager();
        //  $annonce = $em->getRepository('AppBundle:Annonce')->find($t);
        // $session->set('reservId', $reservation->getReservationId());

        return $this->render(':admin/annoncee:Annonce_Modification.html.twig', array(
            'formedit' => $formedit->createView(),
            'annonce' => $annonce,
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));


        //    }
    }


}
