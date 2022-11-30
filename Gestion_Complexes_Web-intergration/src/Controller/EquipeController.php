<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipeController extends AbstractController
{
    /**
     * @Route("/equipe", name="equipe")
     */
    public function index(): Response
    {
        return $this->render('front/equipe.html.twig');
    }

    /**
     * @return Response
     * @Route("/AfficheEquipe",name="AfficheEquipe")
     */
    public function Affiche(){
        $repo=$this->getDoctrine()->getRepository(Equipe::class);
        $Equipe=$repo->findAll();
        return $this->render('Equipe/Affiche.html.twig',['Equipe'=>$Equipe]);

    }

    /**
     * @Route("/Supp/{id}",name="deleteequipe")
     */
    function Delete($id){
        $repo=$this->getDoctrine()->getRepository(Equipe::class);
        $Equipe=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Equipe);
        $em->flush();
        return $this->redirectToRoute('AfficheEquipe');


    }


    /**
     * @param Request $request
     * @return Response
     * @Route("equipe/Add")
     */
    function Add(Request $request){
        $Equipe=new Equipe();
     $form=$this->createForm(EquipeType::class,$Equipe);

     $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
     if($form->isSubmitted()&& $form->isValid())
     {
         $em=$this->getDoctrine()->getManager();
         $em->persist($Equipe);
         $em->flush();
        return $this->redirectToRoute('AfficheEquipe');
     }
     return $this->render('equipe/Add.html.twig',[
         'formequipe'=>$form->createView()
     ]);
    }
    /**
     * @Route("/update/{id}",name="updateequipe")
     */
    function update($id,Request $request){
        $repo=$this->getDoctrine()->getRepository(Equipe::class);
        $Equipe=$repo->find($id);
        $form=$this->createForm(EquipeType::class,$Equipe);
        $form->add('update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheEquipe');
        }
        return $this->render('equipe/Update.html.twig',[
            'fequipe'=>$form->createView()
        ]);

    }
    /**
     * @Route("/fixture", name="fixture")
     */
    public function fixture(): Response
    {
        return $this->render('front/fixture.html.twig');
    }
}
