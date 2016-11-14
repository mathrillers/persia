<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 10/03/2016
 * Time: 14:15
 */

namespace AppBundle\Services;


use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class EmailConfirmationService
{/**
 * @var \AppBundle\Entity\Personne
 */
    private $personne;
    /**
     * @var string
     */
    private $headers;
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $body;
    /**
     * @var string
     */
    private $to;
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $url;

    private $swift;
    private $template;

    /**
     * EmailConfirmationService constructor.
     * @param string $url
     */
    public function __construct(\Swift_Mailer $swift, EngineInterface  $template, $url)
    {
        $this->url = $url;
        $this->swift=$swift;
        $this->template=$template;

    }


    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return \AppBundle\Entity\Personne
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * @param \AppBundle\Entity\Personne $personne
     */
    public function setPersonne($personne)
    {
        $this->personne = $personne;
    }


    /**
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function generateLink(){
        $username=$this->getPersonne()->getCompte()->getUsername();

        $cle = $this->getPersonne()->getCompte()->getSalt();

     return   $link=$this->url."/activate_account/".urlencode($username)."/".urlencode($cle);


}

    public  function sendMailActivation(){
        $email_body = "Vous avez reçu un message depuis www.pereson-immobilier.com .
            \n\n"."Pour valider votre inscription veuillez suivre ce lien:\n\n
            ".$this->generateLink()." \n\n Merci";
// \Swift_Message::newInstance()
        $message = $this->swift->createMessage()
            ->setSubject('Activation de compte')
            ->setFrom('immobilierpereson@gmail.com')
            ->setTo($this->personne->getEmail())
            ->setBody($email_body);
        $this->swift->send($message);
    }

    public  function resetPasswordMail($password,$email){
        $email_body = "Vous avez reçu un message depuis www.pereson-immobilier.com .
            \n\n"."Votre mot de passe a été réinitialisé:\n
                ".$password." \n\n Veuillez vous reconnecter \n Merci";

        $message = $this->swift->createMessage()
            ->setSubject('Password Reset')
            ->setFrom('immobilierpereson@gmail.com')
            ->setTo($email)
            ->setBody($email_body);
        $this->swift->send($message);
    }

   public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}