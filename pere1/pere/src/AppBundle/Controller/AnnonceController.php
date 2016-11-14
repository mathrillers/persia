<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Compte;
use AppBundle\Entity\Immobilier;
use AppBundle\Entity\Notification;
use AppBundle\Entity\Postuler;
use AppBundle\Entity\ProfilNotification;
use AppBundle\Entity\Reservation;
use AppBundle\Form\AnnonceType;
use AppBundle\Form\ImageType2;
use AppBundle\Form\ImmobilierType;
use AppBundle\Form\PersonneType2;
use AppBundle\Form\ResearchType2;
use Knp\Snappy\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Annonce;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AnnonceController extends Controller
{
    /**
     * @Route("/annonce", name="homepageAnnonce")
     */
    public function indexAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $formPart = $this->get('form.factory')->createNamedBuilder( 'formPart')
            ->add ('research',ResearchType2::class)
            ->getForm();

        $annonces2 = $em
            ->getRepository('AppBundle:Annonce')
            ->findAll();

        $annonces  = $this->get('knp_paginator')->paginate($annonces2,$request->query->getInt('page', 1),9);
        if ($request->request->has('formPart')) {

            $formPart->handleRequest($request);
            if($formPart->isSubmitted()) {
                $dataPart= $formPart['research'] ->getData();

                $mot = $dataPart['mot_cle'];
                $ville = $dataPart['ville'];
                $type = $dataPart['typeImmobilier'];
                $acte = $dataPart['actes'];
                if($acte=="Vente"){
                    $budget=$dataPart['budgetVente'];
                }
                elseif($acte=="Location"){
                    $budget=$dataPart['budgetLoc'];
                }
                $link='images/ville/'.$ville->getVilleNom().'/2.jpg';
                list($minpx, $maxpx) = explode(",", $budget);
                $annonces2 = $em->getRepository('AppBundle:Annonce')  ->research($mot, $ville, $type, $acte, $minpx, $maxpx);
                $annonces = $this->get('knp_paginator')->paginate($annonces2, $request->query->getInt('page', 1), 9);

                return $this->render(':visitor:annonces.html.twig', array(
                    'annonces' => $annonces,
                    'last_username' => $lastUsername,
                    'link' => $link,  'ville' =>$ville,
                    'error'         => $error,
                    'user'  => $user,
                    'formPart' => $formPart->createView()
                ));

            }

        }
        $link=null;
        return $this->render(':visitor:annonces.html.twig', array(
            'annonces' => $annonces,
            'last_username' => $lastUsername,
            'link' => $link,
            'error'         => $error,
            'user'  => $user,
            'formPart' => $formPart->createView()
        ));
    }

    /**
     * @Route("/research", name="recherchePage")
     */
    public function cherchAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();


        $form=$this->createForm(ResearchType2::class);
        $form->handleRequest($request);

        $annonces = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Annonce')
            ->findAll();
        $annonces = $this->get('knp_paginator')->paginate($annonces, $request->query->getInt('page', 1), 1);
        if ($form->isSubmitted() ) {

            $mot = $form['mot_cle']->getData();
            $ville = $form['ville']->getData();
            $typeimo = $form['typeImmobilier']->getData();
            $acte = $form['actes']->getData();
            $minpx = $form['min_prix']->getData();
            $maxpx = $form['max_prix']->getData();

            $annonces2 = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Annonce')
                ->research($mot, $ville, $typeimo, $acte, $minpx, $maxpx);

            $annonces = $this->get('knp_paginator')->paginate($annonces2, $request->query->getInt('page', 1), 9);

        }

        return $this->render(':visitor:annonces.html.twig', array(
            'annonces' => $annonces,
            'link' => null,
            'formPart' => $form->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
            'user'  => $user
        ));
    }
    /**
     * @Route("/type/{type}", name="typeannonce")
     */
    public function listtypeAction(Request $request,$type)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $formPart = $this->get('form.factory')->createNamedBuilder( 'formPart')
            ->add ('research',ResearchType2::class)
            ->getForm();

        $annonces2 = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Annonce')
            ->findBy(array('typeAnnonce'=>$type));
        //var_dump($annonces2);
        //die();
        $annonces  = $this->get('knp_paginator')->paginate($annonces2,$request->query->getInt('page', 1),9);
        if ($formPart->isSubmitted() ) {

            $mot = $formPart['mot_cle']->getData();
            $ville = $formPart['ville']->getData();
            $typeimo = $formPart['typeImmobilier']->getData();
            $acte = $formPart['actes']->getData();
            $minpx = $formPart['min_prix']->getData();
            $maxpx = $formPart['max_prix']->getData();

            $annonces2 = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Annonce')
                ->research($mot, $ville, $typeimo, $acte, $minpx, $maxpx);

            $annonces = $this->get('knp_paginator')->paginate($annonces2, $request->query->getInt('page', 1), 9);

        }
        return $this->render(':visitor:annonces.html.twig', array(
            'link' => null,
            'annonces' => $annonces,
            'formPart' => $formPart->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
            'user'  => $user
        ));
    }

    /**
     * @Route("/typeImmob/{type}", name="searchType")
     */
    public function cherchtypeAction(Request $request, $type)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $form=$this->createForm(ResearchType2::class);
        $annonces2 = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Annonce')
            ->typeimmobilier($type);
        //var_dump($annonces2);
        //die();
        $annonces  = $this->get('knp_paginator')->paginate($annonces2,$request->query->getInt('page', 1),9);

        return $this->render(':visitor:annonces.html.twig', array(
            'link' => null,
            'annonces' => $annonces,
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
            'user'  => $user
        ));

    }

    /**
     * @Route("/details/{id}", name="detailsannonce")
     */
    public function detailsAction(Request $request, $id)
    {
        $session = new Session();
        $post=false;
        $reserv=false;
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $annonce = $em
            ->getRepository('AppBundle:Annonce')
            ->find($id);

        $counterService=$this->get('counter');
        if(!$user){


        $counterService->countViewAnonymus($annonce);
    }
        elseif($user){
            $counterService->setUser($user);
            $counterService->countViewAuthen($annonce);
        }

        $images = $em
            ->getRepository('AppBundle:Image')
            ->findByImmobilier($annonce->getImmobilier());
    /*  //  var_dump($annonce);
        var_dump($annonce->getImmobilier()->getQuartier()->getVille()->getVilleNom());
        die();*/

        $annonces = $em
            ->getRepository('AppBundle:Annonce')
            ->annonceCategorie($annonce->getImmobilier()->getQuartier()->getVille(), $annonce->getTypeAnnonce());

        $typeimmob = $em
            ->getRepository('AppBundle:TypeImmobilier')
            ->findAll();


        $formPart = $this->get('form.factory')->createNamedBuilder('formPart')
            ->add('research', ResearchType2::class)
            ->getForm();
        $formReserv = $this->get('form.factory')->createNamedBuilder('formReserv')
           /* ->add('perd', ChoiceType::class, array('label' => 'Durée :', 'label_attr' => array('class' => 'control-label'), 'required' => false, 'placeholder' => 'Choix Par Mois', 'choices' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12')))
           */ ->add('check',CheckboxType::class)
            ->add('valider', SubmitType::class)
            ->getForm();
        $formReservVente = $this->get('form.factory')->createNamedBuilder('formReservVente')
            ->add('check',CheckboxType::class)
            ->add('valider', SubmitType::class)
            ->getForm();
        $formReservCourt = $this->get('form.factory')->createNamedBuilder('formReservCourt')
            ->add('check',CheckboxType::class)
            ->add('valider', SubmitType::class)
            ->getForm();


        $formPayVente = $this->get('form.factory')->createNamedBuilder('formPay')
           ->add('valider', SubmitType::class)
            ->getForm();
        $formPay = $this->get('form.factory')->createNamedBuilder('formPayVente')
            ->add('valider', SubmitType::class)
            ->getForm();
        if ('POST' === $request->getMethod()) {
            if ($request->request->has('formReservVente')) {
                $formReservVente->handleRequest($request);
                if ($formReservVente->isSubmitted()) {

                if($annonce->getDepositaire()===$user->getPersonne()) {
                    $this->createAccessDeniedException("Vous ne pouvez pas postuler à votre propre annonce");
                }

                        $postuler = new Postuler();

                            $postuler->setPostMontant($annonce->getMontant() * 0.20);


                        $postuler->setAnnonce($annonce);
                        $postuler->setPersonne($user->getPersonne());
                        $postuler->setDatePost(new \DateTime('now'));
                        $postuler->setStatut('En Attente');

                    $em->persist($postuler);
                    $em->flush();
/*
                    $notif=new Notification();
                    $notif->setCompte($user);
                    $notif->setDateNotification(new \DateTime());
                    $notif->setTitre("Postulation");
                    $em->persist($notif);

                    $profilNotif=new ProfilNotification();
                    $profilNotif->setCompte($annonce->getDepositaire()->getCompte() );
                    $profilNotif->setActive(true);

                    $profilNotif->setNotification($notif);
                    $profilNotif->setContenu("Votre annonce a reçu une nouvelle postulation");

*/


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

                        if ($formReservVente['check']->getData()) {

                        $session->set('postId',$postuler->getPostId());

                        return $this->redirectToRoute('choix_paiement', array(
                            'postId' => $postuler->getPostId(),));
                    }
                    else {


                        return $this->redirectToRoute('detailsannonce', array(
                            'id' => $id,
                        ));
                    }

                }


            }
           if ($request->request->has('formReserv')) {
                $formReserv->handleRequest($request);
                if ($formReserv->isSubmitted()) {
                    if($annonce->getDepositaire()===$user->getPersonne()) {
                        $this->createAccessDeniedException("Vous ne pouvez pas postuler à votre propre annonce");
                    }


                    if ($formReserv['check']->getData()) {

                        $postuler = new Postuler();
if($annonce->isTypeDelai()){
     $postuler->setPostMontant($annonce->getPeriodeDelai() * $annonce->getPrixDelai() );

}else{
    $postuler->setPostMontant(3* $annonce->getPrixDelai());

}

                        $postuler->setAnnonce($annonce);
                        $postuler->setPersonne($user->getPersonne());
                        $postuler->setDatePost(new \DateTime('now'));
                        $postuler->setStatut('En Attente');
                        $em->persist($postuler);
                        $em->flush();
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


                        // $session->start();
                        $session->set('postId',$postuler->getPostId());


                        return $this->redirectToRoute('choix_paiement', array(
                            'postId' => $postuler->getPostId(),));
                    }
                    else {

                        $postuler = new Postuler();
                        $postuler->setAnnonce($annonce);
                        $postuler->setPersonne($user->getPersonne());
                        //$postuler->setPostMontant($annonce->getMontant());
                        $postuler->setDatePost(new \DateTime('now'));
                        $postuler->setStatut('En Attente');

                        $em->persist($postuler);
                        $em->flush();
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
                        return $this->redirectToRoute('detailsannonce', array(
                            'id' => $id,
                        ));
                    }

                }


            }

            if ($request->request->has('formReservCourt')) {
                /*var_dump($annonce);
                die();*/
                $formReservCourt->handleRequest($request);
                if ($formReservCourt->isSubmitted()) {
                    if($annonce->getDepositaire()===$user->getPersonne()) {
                        $this->createAccessDeniedException("Vous ne pouvez pas postuler à votre propre annonce");
                    }

                    if ($formReservCourt['check']->getData()) {

                        $postuler = new Postuler();
                        $postuler->setAnnonce($annonce);
                        $postuler->setPersonne($user->getPersonne());
                        $postuler->setPostMontant( $annonce->getPrixDelai()* $annonce->getPeriodeDelai()  );
                        $postuler->setDatePost(new \DateTime('now'));
                        $postuler->setStatut('En Attente');
                        $em->persist($postuler);
                        $em->flush();


                        // $session->start();
                        $session->set('postId',$postuler->getPostId());


                        return $this->redirectToRoute('choix_paiement', array(
                            'postId' => $postuler->getPostId(),));
                    }
                    else {

                        $postuler = new Postuler();
                        $postuler->setAnnonce($annonce);
                        $postuler->setPersonne($user->getPersonne());
                        //$postuler->setPostMontant($annonce->getMontant());
                        $postuler->setDatePost(new \DateTime('now'));
                        $postuler->setStatut('En Attente');
                        $em->persist($postuler);
                        $em->flush();
                        return $this->redirectToRoute('detailsannonce', array(
                            'id' => $id,
                        ));
                    }

                }


            }

            if ($request->request->has('formPay')) {
                $formPay->handleRequest($request);
                if ($formPay->isSubmitted()) {

                    if($annonce->getDepositaire()===$user->getPersonne()) {
                        $this->createAccessDeniedException("Vous ne pouvez pas postuler à votre propre annonce");
                    }

                    $postuler = $em->getRepository('AppBundle:Postuler')
                        ->findOneByAnnonceJoinedToPersonne($annonce,$user->getPersonne());
                    $postuler->setPostMontant(3 * $annonce->getPrixDelai());

                    $em->merge($postuler);
                    $em->flush();


                    return $this->redirectToRoute('choix_paiement', array(
                        'postId' => $postuler->getPostId(),));

                }

            }
            if ($request->request->has('formPayVente')) {
                $formPayVente->handleRequest($request);
                if ($formPayVente->isSubmitted()) {


                    $postuler = $em->getRepository('AppBundle:Postuler')
                        ->findOneByAnnonceJoinedToPersonne($annonce,$user->getPersonne());
                    $postuler->setPostMontant(0.2 * $annonce->getMontant());

                    $em->merge($postuler);
                    $em->flush();


                    return $this->redirectToRoute('choix_paiement', array(
                        'postId' => $postuler->getPostId(),));

                }

            }

            if ($request->request->has('formPart')) {

                $formPart->handleRequest($request);
                if ($formPart->isSubmitted()) {
                    $dataPart = $formPart['research']->getData();

                    $mot = $dataPart['mot_cle'];
                    $ville = $dataPart['ville'];
                    $type = $dataPart['typeImmobilier'];
                    $acte = $dataPart['actes'];
                    if($acte=="Vente"){
                        $budget=$dataPart['budgetVente'];
                    }
                    elseif($acte=="Location"){
                        $budget=$dataPart['budgetLoc'];
                    }

                    return $this->redirectToRoute('researchPage', array(
                        'mot' => $mot,
                        'ville' => $ville,
                        'type' => $type,
                        'acte' => $acte,
                        'budget' => $budget,));
                }
            }
        }
        if($user){
            $pos = $em
                ->getRepository('AppBundle:Postuler')
                ->findByAnnonce($annonce);

            foreach ($pos as $poostuler) {
                if ($user->getPersonne()->getPersonneId() == $poostuler->getPersonne()->getPersonneId()) {

                    $post=true;

                    $res = $em
                        ->getRepository('AppBundle:Reservation')
                        ->findOneByPostuler($poostuler);
                    /*var_dump($res);
                                    die();*/
                    if($res){
                        $reserv=true;
                    }

                }
            }
        }
        return $this->render(':visitor:details.html.twig', array(
            'formPay' => $formPay->createView(),
            'formPart' => $formPart->createView(),
            'formReserv' => $formReserv->createView(),
            'formReservVente' => $formReservVente->createView(),
            'formReservCourt' => $formReservCourt->createView(),
            'annonce' => $annonce,
            'annonceplus' => $annonces,
            'typeimmob' => $typeimmob,
            'images' => $images,
            'post' => $post,
            'reserv' => $reserv,
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user,
        ));

    }

    /**
     * @Route("/add", name="addannonce")
     */
    public function addAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        if(!$user){
         $user=new Compte();
        }

        $formAnnonce=$this->get('form.factory')->createNamedBuilder( 'formAnnonce')
            ->add('annonce',AnnonceType::class)
            ->add ('immobilier',ImmobilierType::class)
            ->add('files', FileType::class, array(
                'label' => 'Image(s) du Bien :','label_attr'=>array('class'=>'control-label'),
                'multiple' => true,
                'data_class' => null,))
            ->add ('personne',PersonneType2::class)
            ->add ('conf_psw',PasswordType::class)
            ->add ('isimmo',HiddenType::class)
            ->add('pays', EntityType::class, array(
                'class' => 'AppBundle:Pays',
                'choice_label' => 'paysNom',
                'label'=>'Pays :','label_attr'=>array('class'=>'control-label ')/*,'attr'=>array('class'=>'form-control   m-bot15' )*/
            ))
            ->add('ville',EntityType::class, array(
                'label' => false,
                'class'=>'AppBundle:Ville',
                'attr' => array('placeholder' => 'Select the ville', 'class'=> 'form-control')
            ))
            ->getForm();

        $formInsc = $this->get('form.factory')->createNamedBuilder( 'formInsc')
            ->add ('personne',PersonneType2::class)
            ->add('photo',ImageType2::class)
            ->add ('conf_psw',PasswordType::class)
            ->getForm();


      //  if($user){
            $imobperson = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Immobilier')
                ->findByProprietaire($user->getPersonne());
            $formAnnonce->add('immobilierpers',EntityType::class, array(
                'class'=>'AppBundle\Entity\Immobilier',
                'choices' => $imobperson,
                'label' => false,
                'attr' => array('placeholder' => 'Select the immobilier', 'class'=> 'form-control')
            ));

  /*          $quartiers = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Quartier')
                ->findBy(array('ville'=>$user->getPersonne()));

            $formAnnonce->add('quartier',EntityType::class, array(
                'class'=>'AppBundle\Entity\Quartier',
                //'choices' => $imobperson,
                'attr' => array('placeholder' => 'Select the quartier', 'class'=> 'form-control')
            ));*/
    //    }

       // if($user){

            if ($request->request->has('formInsc')) {
                // handle the second form
                $formInsc->handleRequest($request);
                if ($formInsc->isSubmitted()) {

                    $em = $this->getDoctrine()->getManager();
                    // data is an array with "name", "email", and "message" keys
                    $data = $formInsc['personne']->getData();


                    $u = $em->getRepository('AppBundle:Compte')->findOneByUsername($data->getCompte()->getUsername());
                    if ($u !== null) {
                        $formInsc->get('personne')->addError(new FormError('Veuillez changer le username'));
                        $this->addFlash(
                            'error',
                            'Le Username inséré est déja utilisé'
                        );

                    } else {

                        $encoder = $this->get('security.password_encoder');

                        $passw = $encoder->encodePassword($user, $data->getCompte()->getPassword());
                        $confPass = $encoder->encodePassword($user, $formInsc['conf_psw']->getData());

                        if (strcmp($passw, $confPass) !== 0) {
                            $formInsc->get('personne')->addError(new FormError('Le nouveau mot de passe ne correspond pas à la confirmation'));
                            $formInsc->get('conf_psw')->addError(new FormError('Le nouveau mot de passe ne correspond pas à la confirmation'));
                            $this->addFlash(
                                'error',
                                'Veuillez verifier le mot de passe inséré'
                            );
                        } else {

                            //  $passw=$encoder->encodePassword($user,$data->getCompte()->getPassword());
                            /*JE RECUPERE LE ROLE*/
                            $r = $em->getRepository('AppBundle:Role')
                                ->findOneByRoleNom('ROLE_USER');

                            $data->getCompte()->addRole($r);
                            $data->getCompte()->setPassword($passw);

                            $em->persist($data);
                            $em->persist($data->getCompte());
                            $em->flush();

                            if (null !== $formInsc['photo']->getData()) {
                                $fileService = $this->get('file_upload');

                                $fileService->setImage($formInsc['photo']->getData());
                                $fileService->setPers($data);
                                $fileService->uploadAvatar();


                                if (null !== $fileService->getUrl()) {
                                    $data->getCompte()->setPhoto($fileService->getUrl());
                                    //$em->persist($data->getCompte());
                                }

                                $em->merge($data->getCompte());
                                $em->flush();
                            }
                            $this->addFlash(
                                'notice',
                                'Vous avez etez inscrit'
                            );
                            $token=new UsernamePasswordToken($data->getCompte(),null,'main',$data->getCompte()->getRoles());
                            $this->get('security.token_storage')->setToken($token);


                            return $this->redirectToRoute('addannonce');
                        }
                    }
                }
            }
            if ($request->request->has('formAnnonce')) {
                // handle the second form
                $formAnnonce->handleRequest($request);
                if ($formAnnonce->isSubmitted()) {
                    $em = $this->getDoctrine()->getManager();
                    $anno = $formAnnonce['annonce']->getData();




                    if($formAnnonce['isimmo']->getData()=='yes'){
                        $immo = $formAnnonce['immobilier']->getData();
                    }else{
                        $immo = $formAnnonce['immobilierpers']->getData();
                    }

                    if ($request->request->has('mon_quartier')) {

                    $quarterId=intval($request->request->get('mon_quartier'));
                        $quarter = $em ->getRepository('AppBundle:Quartier')
                            ->find($quarterId);

                        $immo->setQuartier($quarter);
                    }
                    // ===========================================================================================
                    $immo->setProprietaire($user->getPersonne());

                    $em->persist($immo);
                    $em->flush();

                    $fileService = $this->get('file_upload');
                    $fileService->setFiles($formAnnonce['files']->getData());

                    $fileService->upload($immo);
                    $mesImages = $fileService->getImages();

                    if (null !== $mesImages) {
                        foreach ($mesImages as $img) {
                            $em->persist($img);
                        }
                    }
                    $em->flush();

                    $imgimmob = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('AppBundle:Image')
                        ->findOneBy(array('immobilier' => $immo->getImmobilierId()));
                    $immo->setMainImage($imgimmob->getUrl());
                    $em->persist($immo);
                    $em->flush();
                    // ===========================================================================================
                    $anno->setDepositaire($user->getPersonne());
                    $anno->setImmobilier($immo);
                    $anno->setStatutDepot('En Attente');
                    $anno->setDateDepot(new\DateTime('now'));
                    $anno->setMontant($immo->getPrix() + 1000);

                    $em->persist($anno);
                    $em->flush();
                    // ===========================================================================================
                    $immo->setReference('IM00' . $immo->getImmobilierId());
                    $anno->setReference('An00' . $anno->getAnnonceId());
                    $em->persist($immo);
                    $em->persist($anno);
                    $em->flush();

                    return $this->redirectToRoute('mes_annonces');
                }
            }
 //   }

        return $this->render(':visitor:deposer.html.twig', array(
            'formInsc' => $formInsc->createView(),
            'formannonce' => $formAnnonce->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'user'  => $user
        ));
    }

    /**
     * @Route("/validation/{id}", name="validation")
     * @Method({"GET", "POST"})
     */
    public function validationAction(Annonce $annonce)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();


        return $this->render(':visitor:Validation.html.twig', array(
            'annonce' => $annonce,
            // 'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * @Route("/annulation/{id}", name="annulation")
     * @Method({"GET", "POST"})
     */
    public function annulationAction(Annonce $annonce)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':visitor:Transaction-Annuler.html.twig', array(
            'annonce' => $annonce,
            // 'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * @Route("/Choix_Paiement/{postId}", name="choix_paiement")
     * @Method({"GET", "POST"})
     */
    public function checkout_paypalAction($postId)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $post = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Postuler')
            ->find($postId);

        $annonce = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Annonce')
            ->find($post->getAnnonce());


        return $this->render(':visitor:ChoixPaiement.html.twig', array(

            // 'form' => $form->createView(),
            'annonce'=>$annonce,
            'post'=>$post,
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }

    /**
     * @Route("/admin/sub", name="newsletter_sub")
     */
    public function submitnewsletterAction(Request $request)
    {

        $annonces = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Annonce')
            ->newsletter();

        $annoncestop = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Annonce')
            ->newslettertop();

        $newsletters = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Newsletter')
            ->findAll();
        $emails=array();
        foreach($newsletters as $newsletter){
            $emails[]= $newsletter->getEmail();
        }

        $message = \Swift_Message::newInstance()
            ->setSubject('Newsletter from Pereson Immobilier')
            ->setFrom(array('immobilierpereson@gmail.com' => 'Pereson Immobilier'));

        $data['logo'] = $message->embed(\Swift_Image::fromPath('images/newsletter/logo.png'));
        $data['date'] = $message->embed(\Swift_Image::fromPath('images/newsletter/date.png'));
        $data['top_bg'] = $message->embed(\Swift_Image::fromPath('images/newsletter/top_bg.gif'));
        $data['line'] = $message->embed(\Swift_Image::fromPath('images/newsletter/line.jpg'));
        $data['banner_image'] = $message->embed(\Swift_Image::fromPath('images/newsletter/banner-image.jpg'));
        $data['view_details'] = $message->embed(\Swift_Image::fromPath('images/newsletter/view_details.jpg'));
        $data['facebook'] = $message->embed(\Swift_Image::fromPath('images/newsletter/facebook.png'));
        $data['twitter'] = $message->embed(\Swift_Image::fromPath('images/newsletter/twitter.png'));
        $data['google_plus'] = $message->embed(\Swift_Image::fromPath('images/newsletter/google_plus.png'));
        $data['linkedin'] = $message->embed(\Swift_Image::fromPath('images/newsletter/linkedin.png'));
        $data['youtube'] = $message->embed(\Swift_Image::fromPath('images/newsletter/youtube.png'));
        $data['skype'] = $message->embed(\Swift_Image::fromPath('images/newsletter/skype.png'));
        $data['btm_bg'] = $message->embed(\Swift_Image::fromPath('images/newsletter/btm_bg.gif'));
        $data['website'] = $message->embed(\Swift_Image::fromPath('images/newsletter/website.png'));
        foreach($annonces as $annonce){
            //$annonce->getImmobilier()->setMainImage($message->embed(\Swift_Image::fromPath($annonce->getImmobilier()->getMainImage())));
            $data3[$annonce->getAnnonceId()] = $message->embed(\Swift_Image::fromPath($annonce->getImmobilier()->getMainImage()));
        }
        foreach($annoncestop as $annonce){
            $data2[$annonce->getAnnonceId()] = $message->embed(\Swift_Image::fromPath($annonce->getImmobilier()->getMainImage()));
        }

        foreach($emails as $email){
            $message->setTo($email)
                ->setBody(
                    $this->renderView(
                        'swiftlayout/newsletter.html.twig',
                        array('annonces' => $annonces,'annoncestop' => $annoncestop,'data' => $data,'data2' => $data2,'data3' => $data3)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
        }

        return $this->redirectToRoute('newsletter_index');
    }

    /**
     * @Route("/quartier/{id}", name="quartier")
     */
    public function quartierAction(Request $request, $id)
    {
        if($request->isXmlHttpRequest()){
            $quartiers = $this->getDoctrine()->getManager()->getRepository('AppBundle:Quartier')->findBy(array('ville'=>$id));
            $listquartiers= array();
            foreach($quartiers as $quartier){
                $listquartiers[]=array('nom'=>$quartier->getQuartierNom(),'id'=>$quartier->getQuartierId());
            }
            //var_dump($listquartiers);
            //die('ok');
            $response = new JsonResponse();


            return $response->setData(array('quartiers'=>$listquartiers));
        }else{
            throw new \Exception('Erreur');
        }

    }

    /**
     * @Route("/printDetails/{annonceId}", name="printDetails")
     */
    public function printDetailsAction(Request $request, $annonceId)
    {        if ($request->isXmlHttpRequest()) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository('AppBundle:Annonce')->find($annonceId);

        $images = $em
            ->getRepository('AppBundle:Image')
            ->findByImmobilier($annonce->getImmobilier());

        $html= $this->render(':visitor:details-annonce.html.twig', array(
            'annonce' => $annonce,
            'images' => $images,
            'user' => $user,
        ));

      return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="details_annonce.pdf"'
            )
        );
    }}
    /**
     * @Route("/annonce/{id}", name="annonce")
     */
    public function annonceAction(Request $request, $id)
    {
        if ($request->isXmlHttpRequest()) {
            $annonces = $this->getDoctrine()->getManager()->getRepository('AppBundle:Annonce')->findBy(array('depositaire' => $id));
            $listannonces = array();
            foreach ($annonces as $annonce) {
                $listannonces[] = array('titre' => $annonce->getTitre(), 'id' => $annonce->getAnnonceId());
            }
            //var_dump($listquartiers);
            //die('ok');
            $response = new JsonResponse();


            return $response->setData(array('annonces' => $listannonces));
        } else {
            throw new \Exception('Erreur');
        }

    }


    /**
     * @Route("/ville/{id}", name="ville")
     */
    public function villeAction(Request $request, $id)
    {
        if($request->isXmlHttpRequest()){
            $villes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Ville')->findBy(array('pays'=>$id));
            $listvilles= array();
            foreach($villes as $ville){
                $listvilles[]=array('nom'=>$ville->getVilleNom(),'id'=>$ville->getVilleId());
            }
            //var_dump($listquartiers);
            //die('ok');
            $response = new JsonResponse();


            return $response->setData(array('villes'=>$listvilles));
        }else{
            throw new \Exception('Erreur');
        }

    }

    /**
     * @Route("/newsletter/desabonner/{email}", name="newsletter_desabonner")
     */
    public function desabonnernewsletterAction(Request $request, $email)
    {
        $em = $this->getDoctrine()->getManager();
        $newsletter = $em
            ->getRepository('AppBundle:Newsletter')
            ->findOneBy(array('email'=>$email));

        if($newsletter){
            $newsletter->setActive(false);
            $em->merge($newsletter);
            $em->flush();
        }

        return $this->redirectToRoute('newsletter_index');
    }
}
