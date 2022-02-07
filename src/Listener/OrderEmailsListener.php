<?php 

namespace App\Listener;

use App\Event\OrderEvent;
use App\Logger;
use App\Mailer\Email;
use App\Mailer\Mailer;
use Symfony\Component\EventDispatcher\GenericEvent;

class OrderEmailsListener{

    protected $mailer;
    protected $logger;
    public function __construct(Mailer $mailer, Logger $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function sendToStock(OrderEvent $event){

        $order = $event->getOrder();

          // Avant d'enregistrer, on veut envoyer un email à l'administrateur :
        // voir src/Mailer/Email.php et src/Mailer/Mailer.php
        $email = new Email();
        $email->setSubject("Commande en cours")
            ->setBody("Merci de vérifier le stock pour le produit {$order->getProduct()} et la quantité {$order->getQuantity()} !")
            ->setTo("stock@maboutique.com")
            ->setFrom("web@maboutique.com");

            $this->mailer->send($email);

        // Avant d'enregistrer, on veut logger ce qui se passe :
        // voir src/Logger.php
        $this->logger->log("Commande en cours pour {$order->getQuantity()} {$order->getProduct()}");
    }

}


?>