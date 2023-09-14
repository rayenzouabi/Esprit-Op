<?php

namespace App\Controller;

use App\Form\AvisType;
use App\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use App\Repository\AvisRepository;


class AvisController extends AbstractController
{

    #[Route('/avis', name: 'app_avis')]
    public function index(AvisRepository $repository): Response
    {
        $user = $this->getUser();
        $a = $repository->findAllWithCommentaires();
        
        // récupérer tous les avis
        $avis = $this->getDoctrine()->getRepository(Avis::class)->findAll();
        
        // calculer le nombre total d'avis
        $totalAvis = count($avis);
     

    
        // compter le nombre d'avis par étoile
        $countAvisEtoiles = array();
        for ($i = 1; $i <= 5; $i++) {
            $count = 0;
            foreach ($avis as $a) {
                if ($a->getEtoile() == $i) {
                    $count++;
                }
            }
            $countAvisEtoiles[] = $count;
        }
    
        return $this->render('avis/index.html.twig', [
            'a' => $avis,
            'totalAvis' => $totalAvis,
            'countAvisEtoiles' => $countAvisEtoiles,
            'user'=>$user,
        ]);
    


    }


    #[Route('/admin_avis', name: 'admin_avis')]
    public function list_avis(AvisRepository $repository): Response
    {
        $user = $this->getUser();
        $a = $repository->findAllWithCommentaires();
        
        // récupérer tous les avis
        $avis = $this->getDoctrine()->getRepository(Avis::class)->findAll();
        
        // calculer le nombre total d'avis
        $totalAvis = count($avis);
     

    
        // compter le nombre d'avis par étoile
        $countAvisEtoiles = array();
        for ($i = 1; $i <= 5; $i++) {
            $count = 0;
            foreach ($avis as $a) {
                if ($a->getEtoile() == $i) {
                    $count++;
                }
            }
            $countAvisEtoiles[] = $count;
        }
    
        return $this->render('admin/list_avis.html.twig', [
            'a' => $avis,
            'totalAvis' => $totalAvis,
            'countAvisEtoiles' => $countAvisEtoiles,
            'user'=>$user,
        ]);
    


    }
   
    /**
     * @Route("/addavis", name="addAvis")
     */

     public function addAvis(Request $request): Response
     {
         $Avis = new Avis();
         $form = $this->createForm(AvisType::class, $Avis);
         $form->handleRequest($request);
         
         if($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if ($user !== null) {
                $Avis->setUserName($user->getNom());
            }

            $etoile = $request->request->get('etoile');

            
            if ($etoile === null) {
                $etoile = 0;
                throw new Exception('Etoile field cannot be null.');
            }
             
             $Avis->setEtoile($etoile);
                   
             $em = $this->getDoctrine()->getManager();
             $em->persist($Avis);//Add
             $em->flush();
             
             return $this->redirectToRoute('app_avis');
         }
         
         return $this->render('avis/createAvis.html.twig',['f'=>$form->createView()]);
     }
     
     
    #[Route('/removeAvis/{id}', name: 'supavis')]
    public function suppressionAvis(Avis $Avis): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($Avis);
        $em->flush();
        
        
        //return$this->redirectToRoute('supavis');
        return $this->redirectToRoute('app_avis', ['id' => $Avis->getId()]);


    }


    #[Route('/modifavis/{id}', name: 'modifAvis')]
     public function modifAvis(Request $request,$id): Response
     {
         $Avis = $this->getDoctrine()->getManager()->getRepository(Avis::class)->find($id);
         $form = $this->createForm(AvisType::class, $Avis);
 
         $form->handleRequest($request);
 
         if($form->isSubmitted() && $form->isValid()) {
            $etoile = $request->request->get('etoile');
            $user = $this->getUser();

            if ($user !== null) {
                $Avis->setUserName($user->getNom());
            }

            if ($etoile === null) {
                // set a default value
                $etoile = 0;
                // or throw an exception
                throw new Exception('Etoile field cannot be null.');
            }


        $Avis->setEtoile($etoile);

            $em = $this->getDoctrine()->getManager();
             $em->flush();
 
             return $this->redirectToRoute('app_avis'); 
         }
         return $this->render('Avis/updateAvis.html.twig',['f'=>$form->createView()]);
     }

    } 