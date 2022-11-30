<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Entity\WhatsappAPI;
use App\Entity\Terrain;
use App\Form\ReservationType;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class TerrainController extends AbstractController
{
    /**
     * @Route("/terrain", name="terrain")
     */
    public function index(): Response
    {
        return $this->render('terrain/index.html.twig', [
            'controller_name' => 'TerrainController',
        ]);
    }

    /**
     * @Route("/send", name="send")
     */
    public function send(): Response
    {


        $obj = new WhatsappAPI; // create an object of the WhatsappAPI class
        $status = $obj->send("+21620746081", " Une réservation a été créée par votre capitaine d'équipe"); // NOTE: Phone Number should be with country code
        $status = json_decode($status);
        return $this->redirectToRoute("AfficheTerrains");
    }

    /**
     * @Route("/Admin/terrain/add", name="terrain")
     */
    function add(Request $request)
    {
        $terrain = new Terrain();
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->add('Ajouter', SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $terrain->setCreatedAt(new \DateTime('now'));
            $file = $terrain->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('terrain_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $em=$this->getDoctrine()->getManager();

            $terrain->setImage($fileName);

            $em->persist($terrain);
            $em->flush();

            $this -> addFlash('success', 'Terrain bien ajouté avec succès');
            return $this->redirectToRoute("AfficheTerrains");
        }
        return $this->render('Admin/terrain/Ajouter.html.twig',['form' => $form->createView()]);

    }

    /**
     * @param TerrainRepository $repository
     * @return Response
     * @Route ("/AfficheTerrains/", name="AfficheTerrains")
     */
    public function Affiche(TerrainRepository  $repository, Request $request){
        $terrain = new Terrain();
        $l = "";
        $form = $this->createFormBuilder($terrain)
        ->add('designation', TextType::class, array('attr'=>array('class'=>'form-control')))
            ->add('Chercher', SubmitType::class)
            ->getForm();
        //$this->form->bind($request->getParameter('designation'));

        if($form->isSubmitted() && $form->isValid()) {
            $l=$request->get('designation');
            $term = $request->get('designation');
            $tettains = $repository->search($term);
        }
        else {
            $tettains = $repository->findAll();
        }
        return $this->render('admin/terrain/listeTerrains.html.twig', ['terrains' => $tettains, 'form' => $form->createView(), 'l'=>$l,]);
    }

    /**
     * @param TerrainRepository $repository
     * @return Response
     * @Route ("/catalogueTerrains/", name="catalogueTerrains")
     */
    public function catalogueTerrains(TerrainRepository  $repository, Request $request){
        $terrain = new Terrain();
        $l = "";
        $form = $this->createFormBuilder($terrain)
            ->add('designation', TextType::class, array('attr'=>array('class'=>'form-control')))
            ->add('Chercher', SubmitType::class)
            ->getForm();
        //$this->form->bind($request->getParameter('designation'));

        if($form->isSubmitted() && $form->isValid()) {
            $l=$request->get('designation');
            $term = $request->get('designation');
            $tettains = $repository->search($term);
        }
        else {
            $tettains = $repository->findAll();
        }
        return $this->render('front/terrain.html.twig', ['terrains' => $tettains, 'form' => $form->createView(), 'l'=>$l,]);
    }

    /**
     * @param TerrainRepository $repository
     * @return Response
     * @Route ("/AfficheTerrains/{m}", name="filterTerrains")
     */
    public function filter(TerrainRepository  $repository, Request $request){
        $terrain = new Terrain();
        $ter="terrain";
        $l = "";
        $form = $this->createFormBuilder($terrain)
            ->add('designation', TextType::class, array('attr'=>array('class'=>'form-control')))
            ->add('Ajouter', SubmitType::class)
            ->getForm();
        //$this->form->bind($request->getParameter('designation'));


        $form->handleRequest($request);

            $tettains = $repository->search("terrain");


        return $this->render('admin/terrain/listeTerrains.html.twig', ['terrains' => $tettains, 'form' => $form->createView(), 'l'=>$l,]);
    }

    /**
     * @Route("/terrain/supp/{id}", name="d", methods="DELETE")
     */


    function delete(TerrainRepository $repository,Terrain $terrain, Request $request)
    {

        if ($this->isCsrfTokenValid('delete' . $terrain->getId(), $request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($terrain);
            $em->flush();

            $this->addFlash('danger', 'Terrain bien supprimé avec succès');
        }
        else $this->addFlash('danger', 'Terrain non supprimé !');
        return $this->redirectToRoute("AfficheTerrains");
    }
    /**
     * @Route("terrain/update/{id}", name="updateTerrain")
     */

    function Update(TerrainRepository $repository,Request $request, $id){
        $terrain = $repository->find($id);
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $file = $terrain->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('terrain_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $em=$this->getDoctrine()->getManager();

            $terrain->setImage($fileName);


            $em->flush();

            $this -> addFlash('success', 'Terrain bien modifié avec succès');

            return $this->redirectToRoute("AfficheTerrains");
        }
        return $this->render('Admin/terrain/Update.html.twig',['form' => $form->createView()]);
    }


    /**
     * @param TerrainRepository $repository
     * @return Response
     * @Route ("/Terrains", name="TerrainsClient")
     */
    public function AfficheTerrain(TerrainRepository  $repository, Request $request){
        $em = $this->getDoctrine()->getManager();
        $terrains = $em->getRepository(Terrain::class)->findAll();
        if($request->isMethod("post"))
        {
            $term = $request->get('search');
            $terrains = $em->getRepository(Terrain::class)->findTerrainByDesignation($term);
        }
        return $this->render('front/terrain.html.twig', [
            'terrains' => $terrains,
        ]);
    }


    /**
     * @Route("/Terrain/afficher/{id}", name="terrain_show")
     */
    public function show(Request $request): Response
    {




        $em = $this->getDoctrine()->getManager();
        $terrains = $em->getRepository(Terrain::class)->findAll();
        $utilisateur = $em->getRepository(Utilisateur::class)->find(31);

        $reservation = new Reservation();
        if($request->isMethod("post"))
        {
            $terrain = $em->getRepository(Terrain::class)->find($request->get('ter'));

            $reservation->setClient($utilisateur);
            $reservation->setTerrain($terrain) ;
            $reservation->setMontant($terrain->getPrixLocation());
            $date = \DateTime::createFromFormat( $request->get('dat'));
            $reservation->setDateReservation($date);
            //$reservation->setHeure()

            $em->persist($reservation);
            $em->flush();

            $this -> addFlash('success', 'Terrain bien ajouté avec succès');


            return $this->redirectToRoute("AfficheTerrains");

        }



    }
    /*
    public function show(Terrain $terrain,Request $request, UtilisateurRepository $uRep): Response
    {
        $utilisateur = $uRep->find(31);
        $reservation = new Reservation();
        $reservation->setClient($utilisateur);
        $reservation->setTerrain($terrain);
        $reservation->setMontant($terrain->getPrixLocation());
        $reservation->setDateCreation(new \DateTime());

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->add('dateReservation',  DateType::class, array(
            'input'  => 'datetime',
            'widget' => 'single_text',

        ));
        $form->add('heure',TimeType::class, array('widget' => 'single_text' ));
        $form->add('acceptee', null, [
            'label' => "Confirmer sans acceptation des membres"]);
        $form->add('Reserver', SubmitType::class);
       $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $em=$this->getDoctrine()->getManager();

            $em->persist($reservation);
            $em->flush();

            $this -> addFlash('success', 'Terrain bien ajouté avec succès');

            return $this->redirectToRoute("AfficheTerrains");

        }

        return $this->render('front/reservation/sh.html.twig', [
            'terrain' => $terrain, 'reservation'=> $reservation,'form' => $form->createView()
        ]);

    }
    */




    /**
     * @Route("/searchTerrain ", name="searchTerrain")
     */
    public function searchTerrain(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Terrain::class);
        $designation=$request->get('searchValue');
        $terrains = $repository->findTerrainByDesignation($designation);
        $jsonContent = $Normalizer->normalize($terrains, 'json',['groups'=>'terrains']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }


    /**
     * @Route("/recherche ", name="recherche")
     */
    public function recherche(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $terrains = $em->getRepository(Terrain::class)->findAll();
        if($request->isMethod("post"))
        {
            $term = $request->get('search');
            $terrains = $em->getRepository(Terrain::class)->findTerrainByDesignation($term);
        }
        return $this->render('front/terrain.html.twig', [
            'terrains' => $terrains,
        ]);

    }






    /**
     * @Route("/afficher/{id}", name="show_t")
     */
    public function show_t($id): Response
    {




        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository(Utilisateur::class)->find(31);
        $terrain = $em->getRepository(Terrain::class)->find($id);


        $reservation = new Reservation();


        return $this->render('front/reservation/sh.html.twig', [
            'terrain' => $terrain
        ]);

    }














}
