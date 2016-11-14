<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use AppBundle\Entity\Paiement;
use AppBundle\Entity\Postuler;
use AppBundle\Entity\ProfilNotification;
use AppBundle\Entity\Reservation;
use AppBundle\Lib\Simplifycommerce\Simplify\Simplify_Payment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Lib\Simplifycommerce\Simplify;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Payment controller.
 *
 * @Route("/payment",schemes={"https"})
 */

class PaymentController extends Controller
{

    /**
     * @Route("/mastercard", name="mastercard")
     */
    public function responsePaymentAction(Request $request)
    {
        /*
                   amount=5000&paymentId=ddg4M6bG&paymentDate=1420552883439&paymentStatus=APPROVED&authCode=5e6LRN&currency=USD&
               signature=CE7851CA4C6F4FB23F07F4A155324229&reference=REF123

           */

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        /*  $r=$request->query->keys();
                  var_dump($r);
                  die();*/

        $em = $this->getDoctrine()->getManager();/*  var_dump($post);
    die()*/;
        $amount = $request->query->get('amount');
        $paymentId = $request->query->get('paymentId');
        $paymentDate = $request->query->get('paymentDate');
        $paymentStatus = $request->query->get('paymentStatus');
        $authCode = $request->query->get('authCode');
        $currency = $request->query->get('currency');
        $signature = $request->query->get('signature');
        $reference = $request->query->get('reference');

        $key = $this->getParameter("key");

        $payValidationService = $this->get('payment_validation');

        $payValidationService->setAmount($amount);
        $payValidationService->setReference($reference);
        $payValidationService->setPaymentId($paymentId);
        $payValidationService->setPaymentDate($paymentDate);
        $payValidationService->setPaymentStatus($paymentStatus);
        $payValidationService->setPrivateKey($key["private_key"]);

        if ($payValidationService->validationPayment($signature)) {


            $reservation = new Reservation();
            if ($paymentStatus == "APPROVED") {

                $session = new Session();
                $amount=$amount/100;
                $postId = $session->get('postId');
                $post = $em->getRepository('AppBundle:Postuler')
                    ->find($postId);
                if ($post) {
                    $reservation->setPostuler($post);
                    $reservation->setMontant($post->getPostMontant());
                    $reservation->setDateReservation(new \DateTime());
                    //$reservation->setModePaiement("mastercard");


                    $em->persist($reservation);


                    $payment = new Paiement();
                    $payment->setDatePaiement(new \DateTime());
                    $payment->setMontant($amount);
                    $payment->setModePaiement("MASTERCARD");
                    $payment->setReservation($reservation);
                    $em->persist($payment);
                    $em->flush();

                    $notif = new Notification();
                    $notif->setCompte($user);
                    $notif->setDateNotification(new \DateTime());
                    $notif->setIdEntity($payment->getPaiementId());
                    $em->persist($notif);

                    $profilNotif = new ProfilNotification();
                    $profilNotif->setCompte($post->getPersonne()->getCompte());
                    $profilNotif->setActive(true);
                    $profilNotif->setNotification($notif);
                    $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(23));

                    $em->persist($profilNotif);


                    $em->flush();

                    $this->addFlash(
                        'notice',
                        'Votre Paiement a été validé'
                    );
                    return $this->redirectToRoute("home");
                } else {
                    throw new \Exception("Desolé vous n'avez encore pas postulé à cette annonce");
                }
            } else {
                $this->addFlash(
                    'error',
                    'Votre Paiement a été refusé'
                );
                return $this->redirectToRoute("recherchePage");
            }
        } else {
            throw new \Exception('les informations retournées ne sont pas valides! ');
        }

        return $this->render('payment/payment.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user,));
    }


    /**
     * @Route("/mastercard/new", name="mastercard_new")
     */
    public function responseNewPaymentAction(Request $request)
    {
        /*
                   amount=5000&paymentId=ddg4M6bG&paymentDate=1420552883439&paymentStatus=APPROVED&authCode=5e6LRN&currency=USD&
               signature=CE7851CA4C6F4FB23F07F4A155324229&reference=REF123

           */

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        /*  $r=$request->query->keys();
                  var_dump($r);
                  die();*/

        $em = $this->getDoctrine()->getManager();/*  var_dump($post);
    die()*/;
        $amount = $request->query->get('amount');
        $paymentId = $request->query->get('paymentId');
        $paymentDate = $request->query->get('paymentDate');
        $paymentStatus = $request->query->get('paymentStatus');
        $authCode = $request->query->get('authCode');
        $currency = $request->query->get('currency');
        $signature = $request->query->get('signature');
        $reference = $request->query->get('reference');

        $key = $this->getParameter("key");

        $payValidationService = $this->get('payment_validation');

        $payValidationService->setAmount($amount);
        $payValidationService->setReference($reference);
        $payValidationService->setPaymentId($paymentId);
        $payValidationService->setPaymentDate($paymentDate);
        $payValidationService->setPaymentStatus($paymentStatus);
        $payValidationService->setPrivateKey($key["private_key"]);

        if ($payValidationService->validationPayment($signature)) {


     //       $reservation = new Reservation();
            if ($paymentStatus == "APPROVED") {
                $amount=$amount/100;

                $session = new Session();

                $reservId = $session->get('reservId');
                $reserv = $em->getRepository('AppBundle:Reservation')
                    ->find($reservId);
                if ($reserv) {

                    $payment = new Paiement();
                    $payment->setDatePaiement(new \DateTime());
                    $payment->setMontant($amount);
                    $payment->setModePaiement("MASTERCARD");
                    $payment->setReservation($reserv);

                    $em->persist($payment);

                    $reserv->setMontant($reserv->getMontant()+$amount);

                    $em->merge($reserv);

                    $em->flush();

                    $notif = new Notification();
                    $notif->setCompte($user);
                    $notif->setDateNotification(new \DateTime());
                    $notif->setIdEntity($payment->getPaiementId());
                    $em->persist($notif);

                    $profilNotif = new ProfilNotification();
                    $profilNotif->setCompte( $reserv->getPostuler()->getPersonne()->getCompte());
                    $profilNotif->setActive(true);
                    $profilNotif->setNotification($notif);
                    $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(23));
                    $em->persist($profilNotif);

                    $em->flush();

                    $this->addFlash(
                        'notice',
                        'Votre Paiement a été validé'
                    );
                    return $this->redirectToRoute("home");
                } else {
                    throw new \Exception("Desolé vous n'avez encore pas postulé à cette annonce");
                }
            } else {
                $this->addFlash(
                    'error',
                    'Votre Paiement a été refusé'
                );
                return $this->redirectToRoute("recherchePage");
            }
        } else {
            throw new \Exception('les informations retournées ne sont pas valides! ');
        }

        return $this->render('payment/payment.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user,));
    }



    /**
     * @Route("/validMastercard", name="validMastercard")
     */
    public function validationPaymentAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();


        $key = $this->getParameter('key');

        $ann = $em->find('AppBundle:Annonce', 1);


        if ($request->request->has('simplifyToken') == false) {
            return $this->redirectToRoute("home");
        }

        $simplifyToken = $request->request->get('simplifyToken');
        $customerName = $request->request->get('customerName');
        $customerEmail = $request->request->get('customerEmail');
        $paymentStatus = $request->request->get('paymentStatus');


        // $card = $request->request->get('card');
        $type = $request->request->get('type');
        $source = $request->request->get('source');
        $reference = $request->request->get('reference');

//Getting shipping address
        $address = $request->request->get('address');
        $city = $request->request->get('city');
        $state = $request->request->get('state');
        $zip = $request->request->get('zip');

//Generate payment description
        $description = "" . $ann->getDescription();
        $totalAmount = $ann->getMontant();
        //  session_destroy();


        try {
            /*  $r=$request->request->keys();
              var_dump($key);
              var_dump($simplifyToken);
              var_dump($customerName);
              var_dump($customerEmail);
              var_dump($reference);
              var_dump($type);
              var_dump($source);
              var_dump($card);
              var_dump($r);
              die();*/

            Simplify::$publicKey = $key['public_key'];
            Simplify::$privateKey = $key['private_key'];


            // if the save card details flag is set
            if (/*$request->request->get('saveCardDetails') == true &&*/
                isset($customerName) == true && isset($customerEmail) == true
            ) {


                /*      // create a customer
                      $customer = Simplify_Customer::createCustomer(array(
                          'token' => $simplifyToken,
                          'email' => $customerEmail,
                          'name' => $customerName,
                          'reference' => $reference
                      ));

                      // make a payment with the customer
                      $payment = Simplify_Payment::createPayment(array(
                          'amount' => $totalAmount,
                          'description' => $description,
                          'currency' => 'MAD',
                          'customer' => $customer->id
                      ));*/

                /*  } else {*/
                /*    $payment = Simplify_Payment::createPayment(array(
                        "card" => array(
                            "number" => "5555555555554444",
                            "expMonth" => 11,
                            "expYear" => 19,
                            "cvc" => "123"
                        ),
                        'amount' => '1000',
                        'description' => 'prod description',
                        'currency' => 'USD'
                    ));*/
                // make a payment with a card token
                $payment = Simplify_Payment::createPayment(array(
                    'amount' => $totalAmount,
                    'token' => $simplifyToken,
                    'description' => $description,
                    'currency' => 'MAD'
                ));

                if ($payment->paymentStatus == 'APPROVED') {
                    echo "Payment approved\n";

                }
            }
        } catch (\Exception $e) {
            //Something wrong
            //Error handling needed
            var_dump($e);
            die();
            return $this->redirectToRoute("recherchePage");
        }


        return $this->render('payment/payment.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user,));
    }



    /**
     * @Route("/faireDon", name="faire_don")
     */
    public function checkout_paypalAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        return $this->render(':payment:don.html.twig', array(

            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ));
    }



    /**
     * @Route("/don_payment/{amount}", name="don_payment", requirements={"amount" = "\d*,?.?\d*"} )
     */
    public function donPaymentAction(Request $request, $amount)
    {
        $user = $this->getUser();
        $montant=floatval($amount)*100;

        $session = new Session();

        $session->remove('don');
        if ($amount==null || $montant<50) {

                return new Response(' <div class="spacer-10"></div> <div class="alert text-center alert-danger">Veuillez inserer un montant d\'au moins 0.50 Dh</div>');

        }

        $session->set('don',$amount);

        return $this->render(':payment:box-don.html.twig', array(
            'amount'=>$amount,
            'montant'=>$montant,
            'user' => $user
        ));

    }
    /**
     * @Route("/don/mastercard", name="don_mastercard")
     */
    public function responseDonAction(Request $request)
    {

        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $amount = $request->query->get('amount');
        $paymentId = $request->query->get('paymentId');
        $paymentDate = $request->query->get('paymentDate');
        $paymentStatus = $request->query->get('paymentStatus');
        $authCode = $request->query->get('authCode');
        $currency = $request->query->get('currency');
        $signature = $request->query->get('signature');
        $reference = $request->query->get('reference');

        $key = $this->getParameter("key");

        $payValidationService = $this->get('payment_validation');

        $payValidationService->setAmount($amount);
        $payValidationService->setReference($reference);
        $payValidationService->setPaymentId($paymentId);
        $payValidationService->setPaymentDate($paymentDate);
        $payValidationService->setPaymentStatus($paymentStatus);
        $payValidationService->setPrivateKey($key["private_key"]);

        if ($payValidationService->validationPayment($signature)) {

            if ($paymentStatus == "APPROVED") {
                $amount=$amount/100;

                $session = new Session();

                $don = $session->get('don');

                if ($don) {


                    $notif = new Notification();
                    $notif->setCompte($user);
                    $notif->setDateNotification(new \DateTime());
                    $notif->setIdEntity(null);
                    $em->persist($notif);

                    $profilNotif = new ProfilNotification();
                    $profilNotif->setCompte( $user);
                    $profilNotif->setActive(true);
                    $profilNotif->setNotification($notif);
                    $profilNotif->setTypeNotification($em->getRepository('AppBundle:TypeNotification')->find(23));
                    $em->persist($profilNotif);

                    $em->flush();


                    $this->addFlash(
                        'notice',
                        'Votre Don de '.$don.' Dh a été validé'
                    );
                  //  $session->remove('don');

                    return $this->redirectToRoute("home");
                } else {
                    throw new \Exception("Desolé vous n'avez encore pas effectué de don");
                }
            } else {
                $this->addFlash(
                    'error',
                    'Votre Don a été refusé'
                );
                return $this->redirectToRoute("recherchePage");
            }
        } else {
            throw new \Exception('les informations retournées ne sont pas valides! ');
        }

    }



}
