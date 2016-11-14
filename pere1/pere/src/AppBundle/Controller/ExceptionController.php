<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 30/03/2016
 * Time: 15:45
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Exception controller.
 *
 * @Route("/exception")
 */

class ExceptionController extends Controller
{
    /**
 * @Route("/404", name="404")
 */
    public function showExceptionAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':visitor:404.html.twig', array(
            'last_username' => $lastUsername,
            'error'=>$error,
            'user'=>$user));
    }


}