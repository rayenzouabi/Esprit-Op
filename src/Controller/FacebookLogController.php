<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Client\Provider\Facebook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FacebookLogController extends AbstractController
{
    private $provider;

    private $github_provider;
 
 
    public function __construct()
    {
       $this->provider=new Facebook([
         'clientId'          => $_ENV['OAUTH_FACEBOOK_ID'],
         'clientSecret'      => $_ENV['OAUTH_FACEBOOK_SECRET'],
         'redirectUri'       => $_ENV['OAUTH_FACEBOOK_CALLBACK'],
         'graphApiVersion'   => 'v16.0',
     ]);
 
 
 
    }

 
     #[Route('/fcb-login', name: 'fcb_login')]
     public function fcbLogin(): Response
     {
          
         $helper_url=$this->provider->getAuthorizationUrl();
 
         return $this->redirect($helper_url);
     }
 
 
     #[Route('/fcb-callback', name: 'fcb_callback')]
     public function fcbCallBack(UtilisateurRepository $userDb, EntityManagerInterface $manager): Response
     {
        //Récupérer le token
        $token = $this->provider->getAccessToken('authorization_code', [
         'code' => $_GET['code']
         ]);
 
        try {
            //Récupérer les informations de l'utilisateur
 
            $user=$this->provider->getResourceOwner($token);
 
            $user=$user->toArray();
 
            $email=$user['login'];
 
            $nom=$user['name'];
 
            //Vérifier si l'utilisateur existe dans la base des données
 
            $user_exist=$userDb->findByemail($email);
 
            if($user_exist)
            {
                 $user_exist->setNom($nom);
 
                 $manager->flush();
 
 
                 return $this->render('utilisateur/profile.html.twig', [
                     'nom'=>$nom,
                 ]);
 
 
            }
 
            else
            {

                 return $this->render('utilisateur/signup.html.twig', [
                 ]);
 
 
            }
 
 
        } catch (\Throwable $th) {
         //throw $th;
 
           return $th->getMessage();
        }
 
 
     }
 
}

