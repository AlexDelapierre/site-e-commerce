<?php

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendMailService
{
  private $mailer;

  public function __construct(MailerInterface $mailer){}
  
  public function send(string $from, string $to, string $subject, string $template, array $context): void
  { 
    //On crée le mail en instanciant la classe du composant de Symfony qui permet de créer des mails
    $email = (new TemplatedEmail())
      ->from($from)
      ->to($to)
      ->subject($subject)
      ->htmlTemplate("email/$template.html.twig")
      ->context($context);

     //On envoie le mail
     $this->mailer->send($email);   
  }
}