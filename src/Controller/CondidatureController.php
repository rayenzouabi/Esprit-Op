<?php
namespace App\Controller;

use App\Entity\Candidature;
use App\Form\CandidatureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatureController extends AbstractController
{
    
    public function applyForJob(Request $request): Response
    {
        $candidature = new Candidature();

        $form = $this->createForm(CandidatureType::class, $candidature);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidature);
            $entityManager->flush();
        }

        return $this->render('candidature/candidature_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

   
}
