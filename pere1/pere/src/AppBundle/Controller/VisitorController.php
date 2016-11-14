<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Agence;
use AppBundle\Entity\Annonce;
use AppBundle\Entity\Compte;
use AppBundle\Entity\Image;
use AppBundle\Entity\Personne;
use AppBundle\Entity\Role;
use AppBundle\Form\ImageType;
use AppBundle\Form\ImageType2;
use AppBundle\Form\NewsletterType;
use AppBundle\Form\PersonneType;
use AppBundle\Form\PersonneType2;
use AppBundle\Form\ResearchType2;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\CompteType2;

class VisitorController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $notifService=$this->get('notification');
        $session=new Session();
        if(!$session->has("new_notif")){
        $session->set('notif',$notifService->getCount());
    }
        return $this->redirectToRoute('home');

    }

    /**
 * @Route("/accueil", name="home")
 */
    public function accueilAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $annonces2 = $em
            ->getRepository('AppBundle:Annonce')
            ->findBy(array(), array('nbreVues'=>'desc'));

        $annonces = $this->get('knp_paginator')->paginate($annonces2, $request->query->getInt('page',1), 6);

        $formNews = $this->get('form.factory')->createNamedBuilder( 'formNews')
            ->add ('news',NewsletterType::class)
            ->getForm();
        $formAffaire =$this->get('form.factory')->createNamedBuilder( 'formAffaire')
            ->add('besoin',ChoiceType::class, array(
                'choices' => array('Vente' => 'Vente','Location'=>'Location',),
            ))
            ->add('location',EntityType::class, array(
                'label' => 'Ville : ',
                'class'=>'AppBundle\Entity\Ville',
                'attr' => array('placeholder' => 'Select the ville', 'class'=> 'form-control')
            ))
            ->add('type', EntityType::class, array(
                'class' => 'AppBundle:TypeImmobilier',
                'choice_label' => 'nom','label'=>'Type du Bien :','label_attr'=>array('class'=>'control-label ')
            ))
            ->getForm();

        $formPart = $this->get('form.factory')->createNamedBuilder( 'formPart')
            ->add ('research',ResearchType2::class)
            ->getForm();


        if('POST' === $request->getMethod()) {

            if ($request->request->has('formNews')) {

                $formNews->handleRequest($request);
                if($formNews->isSubmitted()){
                    $dataNews=$formNews['news']->getData();
                    $dataNews->setDateInscription(new DateTime("now"));
                    $dataNews->setActive(true);


                    $em->persist($dataNews);
                    $em->flush();

                    return $this->redirectToRoute('home');
                }
            }

            if ($request->request->has('formAffaire')) {

                $formAffaire->handleRequest($request);
                if($formAffaire->isSubmitted()) {
                    $besoin= $formAffaire['besoin'] ->getData();
                    $location= $formAffaire['location'] ->getData();
                    $type= $formAffaire['type'] ->getData();

                    return $this->redirectToRoute('researchAffaire', array(
                        'besoin'=>$besoin,
                        'location'=>$location,
                        'type'=>$type,) );


                }

            }

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
                   return $this->redirectToRoute('researchPage', array(
                       'mot'=>$mot,
                       'ville'=>$ville,
                       'type'=>$type,
                       'acte'=>$acte,
                       'budget'=>$budget,) );


                }

            }
        }

        return $this->render(':visitor:index.html.twig', array('last_username' => $lastUsername,
            'formNews'=>$formNews->createView(),
            'formPart'=>$formPart->createView(),
            'formAffaire' => $formAffaire->createView(),
            'error'=>$error,
            'user'=>$user,
            'annonces'=>$annonces));
    }



    /**
     * @Route("/researchAffaire/{besoin}/{location}/{type}", name="researchAffaire" )
     *
     */
    public function researchAffaireAction($besoin,$location,$type, Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $formPart = $this->get('form.factory')->createNamedBuilder( 'formPart')
            ->add ('research',ResearchType2::class)
            ->getForm();

        $em = $this->getDoctrine()->getManager();


        if ($request->request->has('formPart')) {

            $formPart->handleRequest($request);
            if ($formPart->isSubmitted()) {
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
                return $this->redirectToRoute('researchPage', array(
                    'mot'=>$mot,
                    'ville'=>$ville,
                    'type'=>$type,
                    'acte'=>$acte,
                    'budget'=>$budget,) );

            }
        }
  /*      var_dump($location);
        var_dump($besoin);
        var_dump($type);
        die();*/
        $link='images/ville/'.$location.'/2.jpg';
        $ville=$em->getRepository('AppBundle:Ville')->findOneByVilleNom($location);
        $annonces2 = $em->getRepository('AppBundle:Annonce')  ->researchAffaire($besoin, $ville, $type);
        $annonces = $this->get('knp_paginator')->paginate($annonces2, $request->query->getInt('page', 1), 9);

        return $this->render(':visitor:annonces.html.twig', array(
            'annonces' => $annonces,
            'formPart' => $formPart->createView(),
            'link' => $link, 'ville' => $ville,
            'last_username' => $lastUsername,
            'error'         => $error,
            'user'  => $user
        ));
    }



    /**
     * @Route("/researchs/{ville}/{type}/{acte}/{budget}/{mot}", name="researchPage" , requirements={"mot" = "[^/]*","ville" = "[^/]*","type" = "[^/]*","acte" = "[^/]*"})
     *
     */
    public function researchAction($mot,$ville,$type,$acte,$budget, Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $formPart = $this->get('form.factory')->createNamedBuilder( 'formPart')
            ->add ('research',ResearchType2::class)
            ->getForm();

        $em = $this->getDoctrine()->getManager();


        if ($request->request->has('formPart')) {

            $formPart->handleRequest($request);
            if ($formPart->isSubmitted()) {
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
                return $this->redirectToRoute('researchPage', array(
                    'mot'=>$mot,
                    'ville'=>$ville,
                    'type'=>$type,
                    'acte'=>$acte,
                    'budget'=>$budget,) );

            }
        }
        $link='images/ville/'.$ville.'/1.jpg';

        $ville=$em->getRepository('AppBundle:Ville')->findOneByVilleNom($ville);
            list($minpx, $maxpx) = explode(",", $budget);
            $annonces2 = $em->getRepository('AppBundle:Annonce')  ->research($mot, $ville, $type, $acte, $minpx, $maxpx);
            $annonces = $this->get('knp_paginator')->paginate($annonces2, $request->query->getInt('page', 1), 9);

        return $this->render(':visitor:annonces.html.twig', array(
            'annonces' => $annonces,
            'formPart' => $formPart->createView(),
            'link' => $link, 'ville' => $ville,
            'last_username' => $lastUsername,
            'error'         => $error,
            'user'  => $user
        ));
    }

    /**
     * @Route("/index2", name="home2")
     */
    public function home2Action()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':visitor:annonces.html.twig', array('last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user));
    }
    /**
     * @Route("/propertyList", name="property-list")
     */
    public function propertyListAction(Request $request, Annonce $annonces)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $form=$this->createForm(ResearchType2::class);
        $form->handleRequest($request);

        return $this->render(':visitor:annonces.html.twig', array('last_username' => $lastUsername,
            'form'=>$form->createView(),
            'annonces'=>$annonces,
            'error'=>$error,
            'user'=>$user));
    }
    /**
     * @Route("/propertySingle", name="property-single")
     */
    public function propertySingleAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':visitor:property-single.html.twig', array('last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user));
    }

    /**
     * @Route("/agentList", name="agent-list")
     */
    public function agentListAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':visitor:agent-list.html.twig', array('last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user));
    }
    /**
     * @Route("/agentSingle", name="agent-single")
     */
    public function agentSingleAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':visitor:subscribe.html.twig', array('last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user));
    }
    /**
     * @Route("/features", name="features")
     */
    public function featuresAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':visitor:features.html.twig', array('last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user));
    }
    /**
     * @Route("/blogList", name="blog-list")
     */
    public function blogListAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':visitor:blog-list.html.twig', array('last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user));
    }

    /**
     * @Route("/blogSingle", name="blog-single")
     */
    public function blogSingleAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':visitor:blog-single.html.twig', array('last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user));
    }
    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':visitor:about.html.twig', array('last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user));
    }
    /**
     * @Route("/services", name="services")
     */
    public function servicesAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':visitor:services.html.twig', array('last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user));
    }
    /**
     * @Route("/pricing", name="pricing")
     */
    public function pricingAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':visitor:pricing.html.twig', array('last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user));
    }
    /**
     * @Route("/404", name="404")
     */
    public function errorAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();



        return $this->render(':visitor:404.html.twig', array('last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user));
    }



    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

       $agenceName=$this->getParameter('agence');

        $em = $this->getDoctrine()->getManager();
        $agence=$em->getRepository('AppBundle:Agence')
                    ->findOneByNom($agenceName);

        $formContact = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('email', EmailType::class)

            ->add('number', NumberType::class)
            ->add('message',TextareaType::class)
            ->add('valider',SubmitType::class)
            ->getForm();

        $formContact->handleRequest($request);
        if ($formContact->isSubmitted() ) {
            $data = $formContact->getData();

            $name=$data['name'];
            $email=$data['email'];
            $phone=$data['number'];
            $msg=$data['message'];

            $email_body = "Vous avez reçu un message depuis la page contact de pereson-immobilier.
            \n\n"."Les details:\n\nName: $name\n\nPhone: $phone\n\nEmail: $email\n\nMessage:\n$msg";

            $message = \Swift_Message::newInstance()
                ->setSubject('Message From PERESON IMMOBILIER')
                ->setFrom('immobilierpereson@gmail.com')
                ->setTo('mathrillers@yahoo.fr')
                ->setBody($email_body);

            $this->get('mailer')->send($message);


            $this->addFlash(
                'notice',
                'Votre email a été bien envoyé'
            );

            return $this->redirectToRoute('contact' );
}

        return $this->render(':visitor:contact.html.twig', array('last_username' => $lastUsername,
            'formContact'=>$formContact->createView(),
            'error'=>$error,
            'user'=>$user,
                'agence'=>$agence)
        );
    }

    /**
     * @Route("/subscribe", name="create_account")
     */

    public function createAccountAction(Request $request)
    {


        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = new Compte();
        // $user = $this->getUser();

            if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
        return $this->redirectToRoute("home");
    }
        $em = $this->getDoctrine()->getManager();
        $annonces2 = $em
            ->getRepository('AppBundle:Annonce')
            ->findBy(array(), array('nbreVues'=>'desc'));

        $annonces = $this->get('knp_paginator')->paginate($annonces2, $request->query->getInt('page',1), 4);

        $typeimmob = $em
            ->getRepository('AppBundle:TypeImmobilier')
            ->findAll();

        $formPart = $this->get('form.factory')->createNamedBuilder('formPart')
            ->add('research', ResearchType2::class)
            ->getForm();
        $form = $this->createFormBuilder()
            ->add ('personne',PersonneType2::class)
            ->add('photo',ImageType2::class)
            ->add ('conf_psw',PasswordType::class)
            ->getForm();
        $form->handleRequest($request);
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


        if ($form->isSubmitted()) {


            // data is an array with "name", "email", and "message" keys
            $data = $form['personne']->getData();


            $u=$em->getRepository('AppBundle:Compte')->findOneByUsername($data->getCompte()->getUsername());
            if ($u !== null) {
                $form->get('personne')->addError(new FormError('Veuillez changer le username'));
                $this->addFlash(
                    'error',
                    'Le Username inséré est déja utilisé'
                );

            }
            else {

                $encoder = $this->get('security.password_encoder');

                $passw = $encoder->encodePassword($user, $data->getCompte()->getPassword());
                $confPass = $encoder->encodePassword($user, $form['conf_psw']->getData());

                if (strcmp($passw, $confPass) !== 0) {
                    $form->get('personne')->addError(new FormError('Le nouveau mot de passe ne correspond pas à la confirmation'));
                    $form->get('conf_psw')->addError(new FormError('Le nouveau mot de passe ne correspond pas à la confirmation'));
                    $this->addFlash(
                        'error',
                        'Veuillez verifier le mot de passe inséré'
                    );
                } else {


                    $r = $em->getRepository('AppBundle:Role')
                        ->findOneByRoleNom('ROLE_USER');

                    $data->getCompte()->addRole($r);
                    $data->getCompte()->setPassword($passw);
                    $data->getCompte()->setSalt(md5(microtime(TRUE)*100000));
                    $data->getCompte()->setDateCreation(new DateTime());
                    $em->persist($data);
                    $em->persist($data->getCompte());
                    $em->flush();

                    if (null !== $form['photo']->getData()) {
                        $fileService = $this->get('file_upload');

                        $fileService->setImage($form['photo']->getData());
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
                        'Vous avez eté inscrit'
                    );
                    try{
                        $active=$this->get('email_confirmation');
                        $active->setPersonne($data);

                        $active->sendMailActivation();
                        $this->addFlash(
                            'notice',
                            'Un mail de confirmation a été envoyé à votre @email'
                        );
                    }catch (Exception $e){

                        throw new Exception($e);
                    }

                    return $this->redirectToRoute('login_route');
                }
            }
        }
        return $this->render(':visitor:subscribe.html.twig',array(
            'form'=>$form->createView(),
            'formPart'=>$formPart->createView(),
            'typeimmob' => $typeimmob,
            'annonces' => $annonces,
            'last_username' => $lastUsername,
            'error'=>$error,

        ));
    }
}
