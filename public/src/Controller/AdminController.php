<?php

namespace App\Controller;

use App\Repository\RoleRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;



#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(UtilisateurRepository $utilisateurRepository, RoleRepository $roleRepository): Response
    {
    return $this->render('admin/clientList.html.twig', [
        'users' => $utilisateurRepository->findByRoleId($roleRepository->find(2)),
    ]);
}
  
    #[Route('/listeUser', name: 'liste_admin')]
    public function liste(UtilisateurRepository $utilisateurRepository, RoleRepository $roleRepository): Response
    {       
    return $this->render('admin/clientList.html.twig', [
        'users' => $utilisateurRepository->findByRoleId($roleRepository->find(2))
    ]);
}

#[Route('/login', name: 'login_admin')]
function login(AuthenticationUtils $authenticationUtils): Response
    {
    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();
    return $this->render('utilisateur/login.html.twig', [
        'last_username' => $lastUsername,
        'error' => $error,
    ]);
}

#[Route('/EnableOrdisable/{id}', name: 'EnableOrdisable')]
public function enableOrdisable(UtilisateurRepository $utilisateurRepository,$id,Request $request): Response
{
$user=$utilisateurRepository->find($id);
    $user->setEtat($request->get('etat'));

$utilisateurRepository->save($user, true);
return $this->redirectToRoute('liste_admin');
}

#[Route('/EnableOrdisableInJs/{id}/{etat}' , name: 'EnableOrdisableInJs',methods: ['POST'])]
public function enableOrdisableInJs(UtilisateurRepository $utilisateurRepository,$id,$etat): Response
{
$user=$utilisateurRepository->find($id);
    $user->setEtat($etat);

$utilisateurRepository->save($user, true);
return $this->redirectToRoute('liste_admin');
}
}
