<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Invitation;
use App\Form\EquipeType;
use App\Form\InvitationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvitationController extends AbstractController
{
    /**
     * @Route("/invitation", name="invitation")
     */
    public function index(): Response
    {
        return $this->render('invitation/index.html.twig', [
            'controller_name' => 'InvitationController',
        ]);
    }
    /**
     * @Route("/AfficheInvitation",name="AfficheInvitation")
     */
    function Affiche(){
        $repo=$this->getDoctrine()->getRepository(Invitation::class);
        $Invitation=$repo->findAll();
        return $this->render('invitation/Affiche.html.twig',['Invitation'=>$Invitation]);
    }
    /**
     * @Route("/SuppInvitation/{id}",name="deleteinvitation")
     */
    function Delete($id){
        $repo=$this->getDoctrine()->getRepository(Invitation::class);
        $Invitation=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Invitation);
        $em->flush();
        return $this->redirectToRoute('AfficheInvitation');


    }
    /**
     * @param Request $request
     * @return Response
     * @Route("invitation/Add")
     */
    function Add(Request $request){
        $Invitation=new Invitation();
        $form=$this->createForm(InvitationType::class,$Invitation);

        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($Invitation);
            $em->flush();
            return $this->redirectToRoute('AfficheInvitation');
        }
        return $this->render('invitation/Add.html.twig',[
            'forminvitation'=>$form->createView()
        ]);
    }
    /**
     * @Route("/updateinvitation/{id}",name="updateinvitation")
     */
    function update($id,Request $request){
        $repo=$this->getDoctrine()->getRepository(Invitation::class);
        $Equipe=$repo->find($id);
        $form=$this->createForm(InvitationType::class,$Equipe);
        $form->add('update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheInvitation');
        }
        return $this->render('invitation/Update.html.twig',[
            'finvitation'=>$form->createView()
        ]);

    }
}
