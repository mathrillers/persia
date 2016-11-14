<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Compte;
use AppBundle\Form\ImageType2;
use AppBundle\Form\PersonneType2;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login_route")
     */
    public function loginAction(Request $request)
    {     $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        $formInsc = $this->createFormBuilder()
            ->add ('personne',PersonneType2::class)
            ->add('photo',ImageType2::class)
            ->add ('conf_psw',PasswordType::class)
            ->getForm();
        $formInsc->handleRequest($request);

        // Si le visiteur est d�j� identifi�, on le redirige vers l'accueil
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render(':security:connexion.html.twig',
                array('formInsc'=>$formInsc->createView(),
                    'last_username' => $lastUsername,
                    'error'         => $error,
                    'user'  => $user,
                )
            );
        }
        if ($formInsc->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            // data is an array with "name", "email", and "message" keys
            $data = $formInsc['personne']->getData();


            $u=$em->getRepository('AppBundle:Compte')->findOneByUsername($data->getCompte()->getUsername());
            if ($u !== null) {
                $formInsc->get('personne')->addError(new FormError('Veuillez changer le username'));
                $this->addFlash(
                    'error',
                    'Le Username inséré est déja utilisé'
                );

            }
            else {

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
                    return $this->redirectToRoute('login_route');
                }
            }
            }

return $this->redirectToRoute("home");

    }

    /**
     * @Route("/password-reset", name="password_reset")
     */
    public function resetPasswordAction(Request $request)
    {     $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = new Compte();
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute("login_route");
        }
        $form = $this->createFormBuilder()
            ->add ('username',TextType::class)
            ->add('email',EmailType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            // data is an array with "name", "email", and "message" keys
            $username = $form['username']->getData();
            $email = $form['email']->getData();

            $u=$em->getRepository('AppBundle:Compte')->findOneByUsername($username);
            if ($u == null) {
                $form->get('username')->addError(new FormError('Username Erroné'));
                $this->addFlash(
                    'error',
                    'Aucun compte n"est associé à ce username'
                );

            }
            else {

                if ($u->getPersonne()->getEmail() !== $email) {

                    $form->get('email')->addError(new FormError('Cet email et ce Username ne correspondent pas'));
                    $this->addFlash(
                        'error',
                        'Cet Email ne correspond pas ce username'
                    );
                }else{

                    $encoder = $this->get('security.password_encoder');

                    $reset=$this->get('email_confirmation');

                    $newPsw= $reset->randomPassword();
                    $passwEncode = $encoder->encodePassword($user,$newPsw);

                    $u->setPassword($passwEncode);

                    $em->merge($u);
                    $em->flush();


                    $reset->resetPasswordMail($newPsw,$email);
                    $this->addFlash(
                        'notice',
                        'Votre mot de passe a été réinitialisé'
                    );
                    return $this->redirectToRoute('login_route');
                }
            }
        }

        // Si le visiteur est d�j� identifi�, on le redirige vers l'accueil

            return $this->render(':security:reset-password.html.twig',
                array('form'=>$form->createView(),
                    'last_username' => $lastUsername,
                    'error'         => $error,
                    'user'  => $user,
                )
            );


    }

    /**
     * @Route("/activate_account/{u}/{k}", name="activateAccount")
     */
    public function activateAccountAction($u,$k)
    {
        $em = $this->getDoctrine()->getManager();
       $login= $em->getRepository("AppBundle:Compte")
            ->findOneByUsername(urldecode($u));

        if($login) {
            if ($login->getSalt() == urldecode($k)) {
                $login->setSalt(null);
                $login->setActive(true);
                $em->merge($login);
                $em->flush();
                $token=new UsernamePasswordToken($login,null,'main',$login->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->addFlash(
                    'notice',
                    'Votre compte vient d\'être activé'
                );
            }
else{

    throw new \Exception('Tentative de fraude');
}
        }else{

            throw new \Exception('Tentative de fraude: compte inexistant');
        }

        return $this->redirectToRoute('login_route');

    }
    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
        throw new \Exception('This should never be reached!');
    }
    /**
     * @Route("/logout", name="logout_check")
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }
}
