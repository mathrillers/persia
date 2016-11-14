<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Annonce;
use AppBundle\Entity\Paiement;
use AppBundle\Entity\Postuler;
use AppBundle\Entity\Reservation;
use AppBundle\Form\AnnonceType;
use AppBundle\Form\ImageType2;
use AppBundle\Form\PersonneType2;
use AppBundle\Form\ResearchType2;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
/**
 * Compte controller.
 *
 * @Route("/compte")
 */

class CompteController extends Controller
{



    /**
     * @Route("/editAccount", name="edit_account")
     */

    public function editAccountAction(Request $request){

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('login_route');
        }

        $em = $this->getDoctrine()->getManager();

        $pers= $em->getRepository('AppBundle:Personne')
            ->findOneByPersonneId($user->getPersonne()) ;

        $formPers = $this->get('form.factory')->createNamedBuilder( 'formPers')
            ->add ('personne',PersonneType2::class)
            ->add('photo',ImageType2::class)
            ->getForm();

        $formPass = $this->get('form.factory')->createNamedBuilder( 'formPass')
            ->add ('old_psw',PasswordType::class)
            ->add('new_psw',PasswordType::class)
            ->add ('conf_psw',PasswordType::class)
            ->getForm();


        if('POST' === $request->getMethod()) {

            if ($request->request->has('formPers')) {
                // handle the first form
                $formPers->handleRequest($request);
                if ( $formPers->isSubmitted() ) {

                    $data = $formPers->getData();
                    $newPers=$data['personne'];
                    $newPers->setPersonneId($pers->getPersonneId());

                    $fileService=$this->get('file_upload');

                    $fileService->setImage($data['photo']);
                    // $fileService->setUser($user);
                    $fileService->setPers($newPers);
                    $newPers->setCompte($user);
                    $fileService->uploadAvatar();


                    if(null !==$fileService->getUrl()) {
                        $newPers->getCompte()->setPhoto($fileService->getUrl());

                        $em->merge($newPers->getCompte());
                    }

                    $em->merge($newPers);
                    $em->flush();
                    $this->addFlash(
                        'notice',
                        'Vos informations ont été correctement modifiées'
                    );
                    return $this->redirectToRoute('mon_compte');
                }

            }

            if ($request->request->has('formPass')) {
                // handle the second form
                $formPass->handleRequest($request);


                if ( $formPass->isSubmitted()  ) {
                    $infos = $formPass->getData();

                    $encoder = $this->get('security.password_encoder');

                    $oldPass=$encoder->encodePassword($user,$infos['old_psw']);
                    $newPass=$encoder->encodePassword($user,$infos['new_psw']);
                    $confPass=$encoder->encodePassword($user,$infos['conf_psw']);

                    if(strcmp($oldPass,$user->getPassword())!==0 ){
                        $formPass->get('old_psw')->addError(new FormError('Mot de passe erroné'));
                        $this->addFlash(
                            'error',
                            'Le mot de passe est erroné'
                        );
                    }else{
                        if(strcmp($newPass,$confPass)!==0){
                            $formPass->get('new_psw')->addError(new FormError('Le nouveau mot de passe ne correspond pas à la confirmation'));
                            $formPass->get('conf_psw')->addError(new FormError('Le nouveau mot de passe ne correspond pas à la confirmation'));
                            $this->addFlash(
                                'error',
                                'Le nouveau mot de passe ne correspond pas à la confirmation'
                            );
                        }

                        else{
                            if(strcmp($oldPass,$newPass)===0 ){
                                $formPass->addError(new FormError('Veuillez renouveller votre mot de passe'));
                                $this->addFlash(
                                    'error',
                                    'Veuillez renouveller votre mot de passe'
                                ); }
                            else {
                                $user->setPassword($newPass);
                                $em->merge($user);
                                $em->flush();
                                $this->addFlash(
                                    'notice',
                                    'Vos informations ont été correctement modifiées'
                                );
                                return $this->redirectToRoute('logout_check');
                            }
                        }
                    }

                }

            }
        }
        return $this->render(':visitor:edit-compte.html.twig',array(
                'form'=>$formPers->createView(),
                'psw_form'=>$formPass->createView(),
                'last_username' => $lastUsername,
                'error'=>$error,
                'user'=>$user,
                'personne'=>$pers,
            )
        );

    }
    /**
     * @Route("/mon-compte", name="mon_compte")
     */

    public function myAccountAction(Request $request){

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('login_route');
        }
        $em = $this->getDoctrine()->getManager();



        $annoncesService=$this->get('mes_actions');
        $annoncesService->setUser($user);

        $listPost=$annoncesService->getPostuler();
        $annoncesPost=$annoncesService->mesAnnoncesPost($listPost);
        $listFavoris=$annoncesService->mesAnnoncesFavori($annoncesService->getFavoris());
        $listJaimes=$annoncesService->mesAnnoncesJaime($annoncesService->getJaimes());

        $formPart = $this->get('form.factory')->createNamedBuilder( 'formPart')
            ->add ('research',ResearchType2::class)
            ->getForm();

        if('POST' === $request->getMethod()) {

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
                        'mot'=>$mot,
                        'ville'=>$ville,
                        'type'=>$type,
                        'acte'=>$acte,
                        'budget'=>$budget,) );
                }
            }
        }
        $annoncesPost  = $this->get('knp_paginator')->paginate($annoncesPost,$request->query->getInt('page', 1),2);
        $listFavoris  = $this->get('knp_paginator')->paginate($listFavoris,$request->query->getInt('page', 1),2);
        $listJaimes  = $this->get('knp_paginator')->paginate($listJaimes,$request->query->getInt('page', 1),2);
        return $this->render(':visitor:monCompte.html.twig',array(
                'formPart'=>$formPart->createView(),
                'last_username' => $lastUsername,
                'error'=>$error,
                'user'=>$user,
                'listAnnonce'=>$annoncesPost,
                'listFavoris'=>$listFavoris,
                'listJaimes'=>$listJaimes)
        );

    }
    /**
     * @Route("/biensList", name="mes_biens")
     */
    public function biensListAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $list_biens= $em->getRepository('AppBundle:Immobilier')
            ->findByProprietaire($user->getPersonne());

        $list_immobilier = $this->get('knp_paginator')->paginate($list_biens,$request->query->getInt('page', 1),5);
        return $this->render(':visitor:biens-list.html.twig', array(
                'last_username' => $lastUsername,
                'error'=>$error,
                'user'=>$user,
                'liste'=>$list_immobilier, )
        );
    }
    /**
     * @Route("/mesPostulations", name="mes_postulations")
     */
    public function postListAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $list_post= $em->getRepository('AppBundle:Postuler')
            ->findByPersonne($user->getPersonne());

        $list_annonce=array();
        foreach($list_post as $post) {


            $an =  $em->getRepository('AppBundle:Annonce')
                ->findOneByAnnonceId($post->getAnnonce());

            $list_annonce[]=$an;
        }
        $list_annonces  = $this->get('knp_paginator')->paginate($list_annonce,$request->query->getInt('page', 1),5);
        return $this->render(':visitor:mes-postulations.html.twig', array(
                'last_username' => $lastUsername,
                'error'=>$error,
                'user'=>$user,
                'liste'=>$list_annonces, )
        );
    }

    /**
     * @Route("/mesAnnonces", name="mes_annonces")
     */
    public function mesAnnoncesAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();




        $annoncesService=$this->get('mes_actions');
        $annoncesService->setUser($user);

        $listDepots=$annoncesService->getDepots();

        $list_annonces  = $this->get('knp_paginator')->paginate($listDepots,$request->query->getInt('page', 1),5);
        return $this->render(':visitor:mes-annonces.html.twig', array(
                'last_username' => $lastUsername,
                'error'=>$error,
                'user'=>$user,
                'liste'=>$list_annonces, )
        );
    }

    /**
     * @Route("/mesReservations", name="mes_reservations")
     */
    public function mesReservationsAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();



        $annoncesService=$this->get('mes_actions');
        $annoncesService->setUser($user);

        $listReserv=$annoncesService->mesAnnoncesReservees($annoncesService->getReservations());
        /*var_dump($listReserv);
                die();*/
        $list_annonces  = $this->get('knp_paginator')->paginate($listReserv,$request->query->getInt('page', 1),5);
        return $this->render(':visitor:mes-reservations.html.twig', array(
                'last_username' => $lastUsername,
                'error'=>$error,
                'user'=>$user,
                'liste'=>$list_annonces, )
        );
    }

    /**
     * @Route("/mesFavoris", name="mes_favoris")
     */
    public function mesFavorisAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();


        $annoncesService=$this->get('mes_actions');
        $annoncesService->setUser($user);

        $listFavoris=$annoncesService->mesAnnoncesFavori($annoncesService->getFavoris());

        $list_annonces  = $this->get('knp_paginator')->paginate($listFavoris,$request->query->getInt('page', 1),5);
        return $this->render(':visitor:mes-favoris.html.twig', array(
                'last_username' => $lastUsername,
                'error'=>$error,
                'user'=>$user,
                'liste'=>$list_annonces, )
        );
    }

    /**
     * @Route("/mesNotifications", name="mes_notifications")
     */
    public function mesNotificationsAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $notifService=$this->get('notification');
        $notifService->setUser($user);


        $list_notifs = $this->get('knp_paginator')->paginate($notifService->getNotifications(),$request->query->getInt('page', 1),10);
        $list_old_notifs = $this->get('knp_paginator')->paginate($notifService->getOldNotifs(),$request->query->getInt('page', 1),10);

 /*       var_dump($list_notifs);
        var_dump($list_old_notifs);
        die();*/
        $session=new Session();
        $session->set('notif',$notifService->getCount());
        $session->set('new_notif',0);
        return $this->render(':visitor:mes-notifications.html.twig', array(
                'last_username' => $lastUsername,
                'error'=>$error,
                'user'=>$user,
                'liste'=>$list_notifs,
                'old_liste'=>$list_old_notifs,)
        );
    }
    /**
     * @Route("/ValidNotifs/{id}", name="valid_notif")
     */
    public function validerNotificationsAction(Request $request,$id)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();
        $notif=$em->getRepository('AppBundle:ProfilNotification')->find($id);

        $notif->setActive(false);
        $em->merge($notif);
        $em->flush();

        $notifService=$this->get('notification');
        $notifService->setUser($user);
        return $this->redirectToRoute('mes_notifications');

    }

    /**
     * @Route("/CountNotif", name="count_notif")
     */
    public function countNotificationsAction(Request $request)
    {        if ($request->isXmlHttpRequest()) {
        $session = new Session();

        $notifService = $this->get('notification');

        $count = intval($session->get('notif'));
        $new_count = $notifService->getCount();
        $response = new JsonResponse();

        if ($new_count > $count) {
            $session->set('new_notif', $new_count - $count);
            return $response->setData(array('badge' => '<span id="notif" class="new bg-success badge">new</span>'));
        } else {
            $session->set('notif', $new_count);
            return $response->setData(array('badge' => '<span id="notif" class=" bg-info badge">' . $new_count . ' </span>'));

        }
    }
    }

    /**
     * @Route("/pay/details/{id}", name="detailsPaiement")
     */
    public function detailsPaiementAction(Request $request, $id)
    {
        $paie = true;
        $reserv = false;
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();


        $em = $this->getDoctrine()->getManager();

        $annonce = $em
            ->getRepository('AppBundle:Annonce')
            ->find($id);
        $images = $em
            ->getRepository('AppBundle:Image')
            ->findByImmobilier($annonce->getImmobilier());
        $postuler=new Postuler();
        $reservation=new Reservation();
        $paiements=new Paiement();
        if ($user) {

            $postuler = $em->getRepository('AppBundle:Postuler')
                ->findOneByAnnonceJoinedToPersonne($annonce, $user->getPersonne());
            $reservation = $em->getRepository('AppBundle:Reservation')
                ->findOneByPostuler($postuler);

            $this->denyAccessUnlessGranted('view',$postuler);

            if ($reservation) {

                $reserv = true;
                $paiements = $em->getRepository('AppBundle:Paiement')
                    ->findByReservation($reservation);

                $sum = 0;
                foreach ($paiements as $pay) {
                    $sum += $pay->getMontant();


                }
                if ($postuler->getPostMontant() > $sum) {

                    $paie = false;
                }

            }


        }


        $formNewPay = $this->get('form.factory')->createNamedBuilder('formNewPay')
            ->add('choix', NumberType::class)
            ->add('valider', ButtonType::class)
            ->getForm();
        $formPay = $this->get('form.factory')->createNamedBuilder('formPay')
            ->add('perd', ChoiceType::class, array('label' => 'Durée :', 'label_attr' => array('class' => 'control-label'), 'choices' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12')))
            ->add('valider', SubmitType::class)
            ->getForm();
        if ('POST' === $request->getMethod()) {


            if ($request->request->has('formPay')) {
                $formPay->handleRequest($request);
                if ($formPay->isSubmitted()) {


                    $data = intval($formPay['perd']->getData());


                    $postuler = $em->getRepository('AppBundle:Postuler')
                        ->findOneByAnnonceJoinedToPersonne($annonce, $user->getPersonne());
                    $postuler->setPostMontant(($data * $annonce->getPrixDelai()) + (($data * $annonce->getPrixDelai()) * $annonce->getCommission() / 100));

                    $em->merge($postuler);
                    $em->flush();


                    return $this->redirectToRoute('choix_paiement', array(
                        'postId' => $postuler->getPostId(),));

                }

            }


        }

        return $this->render(':visitor:paiement-annonce.html.twig', array(
            'formPay' => $formPay->createView(),
            'formNewPay' => $formNewPay->createView(),
            'annonce' => $annonce,
            'images' => $images,
            'paie' => $paie,
            'reserv' => $reserv,
            'paiements' => $paiements,
            'reservation' => $reservation,
            'postuler' => $postuler,
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user,
        ));

    }

    /**
     * @Route("/pay/new/{post}/{tranche}", name="new_pay")
     */
    public function newPaymentAction(Request $request, $post, $tranche)
    {
        if ($request->isXmlHttpRequest()) {
        $user = $this->getUser();
        $amount=0;
        $em = $this->getDoctrine()->getManager();

        $postuler = $em->getRepository('AppBundle:Postuler')->find($post);

        $t=intval($tranche);
        $session = new Session();

        $session->remove('reservId');
        switch ($t) {
            case null:

                return new Response(' <div class="spacer-10"></div> <div class="alert text-center alert-danger">Veuillez choisir une tranche</div>');
                break;

            default:

                $amount = ($postuler->getAnnonce()->getPrixDelai()) * $t;
                break;

        }   }

        $reservation = $em->getRepository('AppBundle:Reservation')->findOneByPostuler($postuler);
        $session->set('reservId',$reservation->getReservationId());

        return $this->render(':payment:box-payment.html.twig', array(
            'annonce'=>$postuler->getAnnonce(),
            'post'=>$postuler,
            'montant'=>$amount *100,

            'user' => $user
        ));

    }

    /**
     * @Route("/addFavorites/{annonceId}", name="add_favorites")
     */
    public function addFavoritesAction(Request $request, $annonceId)
    {        if ($request->isXmlHttpRequest()) {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $annonce = $em->getRepository('AppBundle:Annonce')->find($annonceId);

        $counterService = $this->get('counter');
        $counterService->setUser($user);

        if ($counterService->addFavorites($annonce)) {

            return new Response('<i class="fa fa-star"></i> ');

        } else {
            $counterService->removeFavorites($annonce);
            return new Response('<i class="fa fa-star-o"></i> ');

        }
    } }

    /**
     * @Route("/facture/{annonceId}", name="facture")
     */
    public function factureAction(Request $request, $annonceId)
    {
        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser();

            $em = $this->getDoctrine()->getManager();

            $annonce = $em->getRepository('AppBundle:Annonce')->find($annonceId);

            $images = $em
                ->getRepository('AppBundle:Image')
                ->findByImmobilier($annonce->getImmobilier());
            if ($user) {

                $postuler = $em->getRepository('AppBundle:Postuler')
                    ->findOneByAnnonceJoinedToPersonne($annonce, $user->getPersonne());
                $reservation = $em->getRepository('AppBundle:Reservation')
                    ->findOneByPostuler($postuler);

                if ($reservation) {

                    $paiements = $em->getRepository('AppBundle:Paiement')
                        ->findByReservation($reservation);


                }


            }

            return $this->render(':payment:facture.html.twig', array(
                'annonce' => $annonce,
                'images' => $images,
                'paiements' => $paiements,
                'reservation' => $reservation,
                'postuler' => $postuler,

            ));


        }
    }

    /**
     * @Route("/createBills/{annonceId}", name="facturation")
     */
    public function createBillsAction(Request $request, $annonceId)
    {
        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser();

            $em = $this->getDoctrine()->getManager();

            $annonce = $em->getRepository('AppBundle:Annonce')->find($annonceId);

            $images = $em
                ->getRepository('AppBundle:Image')
                ->findByImmobilier($annonce->getImmobilier());
            if ($user) {

                $postuler = $em->getRepository('AppBundle:Postuler')
                    ->findOneByAnnonceJoinedToPersonne($annonce, $user->getPersonne());
                $reservation = $em->getRepository('AppBundle:Reservation')
                    ->findOneByPostuler($postuler);

                if ($reservation) {
                    $paiements = $em->getRepository('AppBundle:Paiement')
                        ->findByReservation($reservation);


                }


            }

            $html = $this->render(':payment:facture.html.twig', array(
                'annonce' => $annonce,
                'images' => $images,
                'paiements' => $paiements,
                'reservation' => $reservation,
                'postuler' => $postuler,

                'user' => $user,
            ));

            return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="file.pdf"'
                )
            );
        } }


    /**
     * @Route("/edit/{id}", name="editannonce")
     */
    public function editAction(Annonce $annonce, Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $this->denyAccessUnlessGranted('edit', $annonce);

        $depo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Personne')->find($annonce->getDepositaire());
        $prop = $this->getDoctrine()->getManager()->getRepository('AppBundle:Personne')->find($annonce->getImmobilier()->getProprietaire());
        $images = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Image')
            ->findBy(array('immobilier'=>$annonce->getImmobilier()));

        $annonce2 = $this->getDoctrine()->getManager()->getRepository('AppBundle:Annonce')->find($annonce);

        $formAnnonce=$this->createForm(AnnonceType::class, $annonce2);
        $formville=$this->createFormBuilder()
            ->add('ville',EntityType::class, array(
                'label' => 'Ville : ',
                'class'=>'AppBundle:Ville',
                'attr' => array('placeholder' => 'Select the ville', 'class'=> 'form-control')
            ))
            ->add('pays',EntityType::class, array(
                'label' => 'Pays : ',
                'class'=>'AppBundle:Pays',
                'attr' => array('placeholder' => 'Select the pays', 'class'=> 'form-control')
            ))->getForm();
        $formAnnonce->handleRequest($request);

        $formfiles=$this->createFormBuilder()
            ->add('files', FileType::class, array(
                'label' => 'Image(s) du Bien :','label_attr'=>array('class'=>'control-label'),
                'multiple' => true,
                'data_class' => null,))
            ->add('save', SubmitType::class, array('label'=>'Telecharger','attr' => array('class' => 'btn btn-primary right', 'style' => 'margin-top: 12px;')))
            ->getForm();
        $formfiles->handleRequest($request);

        if ($formfiles->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $fileService = $this->get('file_upload');
            $fileService->setFiles($formfiles['files']->getData());

            $fileService->upload($annonce2->getImmobilier());
            $mesImages = $fileService->getImages();

            if (null !== $mesImages) {
                foreach ($mesImages as $img) {
                    $em->persist($img);
                }
            }
            $em->flush();

            return $this->redirectToRoute('editannonce',array('id'=>$annonce->getAnnonceId()));
        }

        if ($formAnnonce->isSubmitted()&& $formAnnonce->isValid()) {

            if ($request->request->has('mon_quartier')) {
                $em = $this->getDoctrine()->getManager();
                $quarterId=intval($request->request->get('mon_quartier'));
                $quarter = $em ->getRepository('AppBundle:Quartier')
                    ->find($quarterId);
                $annonce2->getImmobilier()->setQuartier($quarter);
                $em->clear('AppBundle:Quartier');
            }
            $em = $this->getDoctrine()->getManager();
            $annonce2->setDepositaire($depo);
            $annonce2->setReference('An00'.$annonce2->getAnnonceId());
            $annonce2->setMontant($annonce2->getImmobilier()->getPrix()+1000);
            $annonce2->getImmobilier()->setProprietaire($prop);
            $annonce2->getImmobilier()->setReference('IM00'.$annonce2->getImmobilier()->getImmobilierId());
            //var_dump($annonce2);
            //die();
            $em->merge($annonce2);
            $em->flush();

            return $this->redirectToRoute('homepageAnnonce');
        }

        return $this->render(':visitor:edit_annonce.html.twig', array(
            'annonce' => $annonce2,
            'images' => $images,
            'last_username' => $lastUsername,
            'error'         => $error,
            'user'  => $user,
            'formannonce' => $formAnnonce->createView(),
            'formville' => $formville->createView(),
            'formfiles' => $formfiles->createView()
        ));
    }

    /**
     * @Route("/delete/{id}", name="deleteannonce")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository('AppBundle:Annonce')->find($id);

        $this->denyAccessUnlessGranted('delete', $annonce);
        $em->remove($annonce);
        $em->flush();

        return $this->redirectToRoute('mes_annonces');
    }

    /**
     * @Route("/Image/delete/{AnnonceId}/{id}", name="image_delete")
     */
    public function deleteImageAction(Request $request, $AnnonceId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('AppBundle:Image')->find($id);
        $annonce = $em->getRepository('AppBundle:Annonce')->find($AnnonceId);

        $this->denyAccessUnlessGranted('delete', $annonce);
        $em->remove($image);
        $em->flush();
        return $this->redirectToRoute('editannonce',array('id'=>$AnnonceId));
    }

    /**
     * @Route("/Image/edit/{AnnonceId}/{id}", name="image_edit")
     */
    public function editImageAction(Request $request, $AnnonceId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('AppBundle:Image')->find($id);
        $images = $em->getRepository('AppBundle:Image')->findBy(array('immobilier'=>$image->getImmobilier()));
        $annonce = $em->getRepository('AppBundle:Annonce')->find($AnnonceId);

        $this->denyAccessUnlessGranted('delete', $annonce);
        foreach($images as $img){
            $img->setBienActive(false);
        }

        $image->getImmobilier()->setMainImage($image->getUrl());
        $image->setBienActive(true);

        $em->merge($image);
        $em->flush();
        return $this->redirectToRoute('editannonce',array('id'=>$AnnonceId));
    }

}
