<?php

namespace App\Controller;

use App\Entity\PenaliteJoueur;
use App\Form\PenaliteJoueurType;
use App\Repository\PenaliteJoueurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class PenaliteJoueurController extends AbstractController
{
    /**
     * @Route("/penaliteJoueur", name="penaliteJoueur")
     */
    public function index(): Response
    {
        return $this->render('penaliteJoueur/index.html.twig', [
            'controller_name' => 'PenaliteJoueurController',
        ]);
    }

    /**
     * @Route("/penaliteJoueur/add", name="penaliteJoueur")
     */
    function add(Request $request)
    {
        $penaliteJoueur = new PenaliteJoueur();
        $form = $this->createForm(PenaliteJoueurType::class, $penaliteJoueur);

        $form->add('Ajouter', SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($penaliteJoueur);
            $em->flush();

            return $this->redirectToRoute("AffichePenaliteJoueur");
        }
        return $this->render('Arbitre/PenaliteJoueur/Ajouter.html.twig',['form' => $form->createView()]);

    }

    /**
     * @param PenaliteJoueurRepository $repository
     * @return Response
     * @Route ("/AffichePenaliteJoueur/", name="AffichePenaliteJoueur")
     */
    public function Affiche(PenaliteJoueurRepository  $repository){
        $penaliteJoueur = $repository->findAll();
        return $this->render('Arbitre/penaliteJoueur/listePenalitesJoueur.html.twig', ['penaliteJoueur' => $penaliteJoueur]);
    }

    /**
     * @Route("penalite/update/{id}", name="updatePenaliteJoueur" , methods="UpdateJ")
     */

    function Update(PenaliteJoueurRepository  $repository,Request $request, $id){
        $penaliteJoueur = $repository->find($id);
        $form = $this->createForm(PenaliteType::class, $penaliteJoueur);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            $this -> addFlash('success', 'Penalité Joueur bien modifiée avec succès');

            return $this->redirectToRoute("AffichePenaliteJoueur");
        }
        return $this->render('Arbitre/penaliteJoueur/Update.html.twig',['form' => $form->createView()]);
    }


    /**
     * @Route("/penalite/supp/{id}", name="dpj", methods="DELETEJ")
     */
    function delete($id, PenaliteJoueur $penaliteJoueur, Request $request)
    {



        $em = $this->getDoctrine()->getManager();
        $em->remove($penaliteJoueur);
        $em->flush();

        $this->addFlash('danger', 'Penalité Joueur bien supprimée avec succès');


        return $this->redirectToRoute("AffichePenaliteJoueur");
    }

    /*
     /**
         * @Route("/searchPenalite ", name="searchPenalites")
         */

    /* public function searchPenalite(Request $request,NormalizerInterface $Penalite)
     {
         $repository = $this->getDoctrine()->getRepository(Penalite::class);
         $requestString=$request->get('searchValue');
         $Penalite = $repository->findPenaliteByNsc($requestString);
         $jsonContent = $Normalizer->normalize(Penalite, 'json',['groups'=>'Penalites:read']);
         $retour=json_encode($jsonContent);
         return new Response($retour);

     }
  */

    /**
     * @Route("/pdf", name="pdf")
     */
    public function Affichep(PenaliteJoueurRepository $repository){

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $penalitesJoueurs = $repository->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('Arbitre/PenaliteJoueur/pdf.html.twig', ['penalitesJoueurs' => $penalitesJoueurs]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
        return $this->render('home');

    }



}
