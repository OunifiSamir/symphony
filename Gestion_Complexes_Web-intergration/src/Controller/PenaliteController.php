<?php

namespace App\Controller;

use App\Entity\Penalite;
use App\Form\PenaliteType;
use App\Repository\PenaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;



class PenaliteController extends AbstractController
{
/**
*@Route("/",name="article_list")
*/
    public function home(Request$request)
    {
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $propertySearch);
        $form->handleRequest($request);
        $articles = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $propertySearch->getNom();
            if ($nom != "")


                $articles = $this->getDoctrine()->getRepository(Article::class)->findBy(['nom' => $nom]);
            else
                //sisiaucunnom n'estfournionaffichetouslesarticles
                $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

                return $this->render('penalite/index.html.twig', ['controller_name' => 'PenaliteController',]);
    }
    }

    /**
     * @Route("/penalite/add", name="penalite")
     */
    function add(Request $request)
    {
        $penalite = new Penalite();
        $form = $this->createForm(PenaliteType::class, $penalite);
        $form->add('Ajouter', SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($penalite);
            $em->flush();

            return $this->redirectToRoute("AffichePenalites");
        }
        return $this->render('Arbitre/penalite/Ajouter.html.twig',['form' => $form->createView()]);

    }

    /**
     * @param PenaliteRepository $repository
     * @return Response
     * @Route ("/AffichePenalite/", name="AffichePenalites")
     */
    public function Affiche (PenaliteRepository  $repository){
        $penalite = $repository->findAll();
        return $this->render('Arbitre/penalite/listePenalites.html.twig', ['penalites' => $penalite]);
    }

    /**
     * @Route("penalite/update/{id}", name="UpdatePenalite" )
     */

    function Update(PenaliteRepository $repository,Request $request, $id){
        $penalite = $repository->find($id);
        $form = $this->createForm(PenaliteType::class, $penalite);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            $this -> addFlash('success', 'Penalité bien modifiée avec succès');

            return $this->redirectToRoute("AffichePenalites");
        }
        return $this->render('Arbitre/penalite/Update.html.twig',['form' => $form->createView()]);
    }


    /**
     * @Route("/penalite/supp/{id}", name="dp", methods="DELETE")
     */
    function delete($id, Penalite $penalite, Request $request)
    {



        $em = $this->getDoctrine()->getManager();
        $em->remove($penalite);
        $em->flush();

        $this->addFlash('danger', 'Penalité bien supprimée avec succès');


        return $this->redirectToRoute("AffichePenalites");
    }

/*
 /**
     * @Route("/searchPenalite ", name="searchPenalite")
     */

 /*  public function searchPenalite(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Penalite::class);
        $requestString=$request->get('searchValue');
        $Penalite = $repository->findPenaliteByNsc($requestString);
        $jsonContent = $Normalizer->normalize($Penalite, 'json',['groups'=>'Penalites:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }
 **/


}
