<?php
namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport;


class MailerService extends AbstractController
{
   public function __construct(private MailerInterface $mailer)
    {
        
    }
        public function sendRegistrationEmail(MailerInterface $mailer,$email,$username)
        {
            $html = $this->renderView('RegistrationEmail/registrationEmail.html.twig', [
                'username' => $username,
            ]);
            $email = (new TemplatedEmail())
                ->from('swiftride2023@gmail.com')
                ->to($email)
                ->subject('Création du comtpe')
                ->html($html)
            ;
            //$tranport = Transport::fromDsn('smtp://swiftride2023@gmail.com:mtawexjymmjcuceg@smtp.gmail.com:587?verify_peer=0');
//$mailer=new Mailer($tranport);
            $mailer->send($email);
        }
}