<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Annonce;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Newsletter;

/**
 * Newsletter controller.
 *
 * @Route("/admin/newsletter")
 */
class NewsletterController extends Controller
{
    /**
     * Lists all Newsletter entities.
     *
     * @Route("/", name="newsletter_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $newsletters = $em->getRepository('AppBundle:Newsletter')->findAll();

        if(!$newsletters){
            $personnes  = $em->getRepository('AppBundle:Personne')->findAll();
        //$news=array();
            foreach($personnes as $pers){
                $newsletter = new Newsletter();
                $newsletter->setEmail($pers->getEmail());
                $newsletter->setActive(true);
                $newsletter->setDateInscription(new\DateTime('now'));
                //$news[]=$newsletters2;

                $em->persist($newsletter);
                $em->flush();
            }
            //var_dump($news);
            //die();
            $newsletters = $em->getRepository('AppBundle:Newsletter')->findAll();
        }

        $annonces = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Annonce')
            ->findAll();
        $formSelect = $this->createFormBuilder()
            ->add ('maxannonces',ChoiceType::class, array('label' => 'Max Annonces : ', 'choices' => array('3' => '3','4' => '4', '5' => '5', '6' => '6','7' => '7', '8' => '8', '9' => '9','10' => '10')))
            ->add('annonces', EntityType::class, array(
                'class' => 'AppBundle:Annonce',
                //'choices'=>$imobperson,
                'multiple' => true,
                'expanded' => true,
                'label'=>'Biens :'
            ))
            ->getForm();
        $formSelect->handleRequest($request);

        if ($formSelect->isSubmitted()) {
            $ids=$request->request->get('mesIds');
            $selctannonces[]= new Annonce;
            $i=0;
            if($ids){
                foreach($ids as $id){
                    /*$selctannonces[$i] = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('AppBundle:Annonce')
                        ->findBy(array('annonceId'=>$id));*/
                    foreach($annonces as $annonce){
                        if($id==$annonce->getAnnonceId()){
                            $selctannonces[$i]=$annonce;
                            $i++;
                        }
                    }
                }

                $newsletters = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:Newsletter')
                    ->findAll();
                $emails=array();
                foreach($newsletters as $newsletter){
                    if($newsletter->getActive()==true){
                        $emails[]= $newsletter->getEmail();
                    }
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

                foreach($selctannonces as $annonce){
                    $data3[$annonce->getAnnonceId()] = $message->embed(\Swift_Image::fromPath($annonce->getImmobilier()->getMainImage()));
                }

                foreach($emails as $email){
                    $message->setTo($email)
                        ->setBody(
                            $this->renderView(
                                'swiftlayout/newsletter.html.twig',
                                array('email' => $email,'annonces' => $selctannonces,'data' => $data,'data3' => $data3)
                            ),
                            'text/html'
                        );
                    $this->get('mailer')->send($message);
                }

                return $this->redirectToRoute('newsletter_index');
            }
            /*var_dump($annonces);
            var_dump('----------------------------------');
            var_dump($selctannonces);
            die();
            return $this->redirectToRoute('newsletter_sub', array('maxann' => $formSelect['maxannonces']->getData(),'topann' => $formSelect['topannonces']->getData()));*/
        }

        return $this->render('admin/newsletter/index.html.twig', array(
            'newsletters' => $newsletters,
            'last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user,
            'formSelect' => $formSelect->createView(),
            'annonces'=>$annonces,
        ));
    }

    /**
     * Creates a new Newsletter entity.
     *
     * @Route("/new", name="newsletter_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $newsletter = new Newsletter();
        $form = $this->createForm('AppBundle\Form\NewsletterType', $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            return $this->redirectToRoute('newsletter_index');
        }

        return $this->render('admin/newsletter/new.html.twig', array(
            'newsletter' => $newsletter,
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user
        ));
    }

    /**
     * Displays a form to edit an existing Newsletter entity.
     *
     * @Route("/{id}/edit", name="newsletter_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Newsletter $newsletter)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $editForm = $this->createForm('AppBundle\Form\NewsletterType', $newsletter);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            return $this->redirectToRoute('newsletter_index');
        }

        return $this->render(':admin/newsletter:edit.html.twig', array(
            'newsletter' => $newsletter,
            'edit_form' => $editForm->createView(),
            'last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user
        ));
    }

    /**
     * Deletes a Newsletter entity.
     *
     * @Route("/delete/{id}", name="newsletter_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Newsletter $newsletter)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($newsletter);
            $em->flush();

        return $this->redirectToRoute('newsletter_index');
    }

}
