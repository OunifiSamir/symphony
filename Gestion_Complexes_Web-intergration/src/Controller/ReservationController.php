<?php

namespace App\Controller;
use App\Entity\Reservation;
use App\Entity\Terrain;
use App\Entity\Utilisateur;
use App\Form\ReservationType;
use App\Form\TerrainType;
use App\Repository\ReservationRepository;
use App\Repository\TerrainRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\MonologBundle\SwiftMailer;
use Dompdf\Dompdf;
use Dompdf\Options;


class ReservationController extends AbstractController
{

    /**
     * @Route("/reservation/add", name="re")
     */
    function add(Request $request)
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->add('Ajouter', SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $reservation->setDateCreation(new \DateTime('now'));

            $em=$this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            $this -> addFlash('success', 'Réservation bien ajoutée avec succès');
            return $this->redirectToRoute("AfficheReservations");
        }
        return $this->render('Admin/reservation/Ajouter.html.twig',['form' => $form->createView()]);

    }

    /**
     * @param ReservationRepository $repository
     * @return Response
     * @Route ("/AfficheReservations/", name="Reservations")
     */
    public function Affiche(ReservationRepository  $repository){
        $reservations = $repository->findAll();
        return $this->render('Admin/reservation/listeReservations.html.twig', ['reservations' => $reservations]);
    }

    /**
     * @Route("/reservation/supp/{id}", name="d", methods="DELETE")
     */


    function delete(Reservation $reservation, Request $request)
    {


        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();

            $this->addFlash('danger', 'Réservation annulée');
        }
        else $this->addFlash('danger', 'err !');
        return $this->redirectToRoute("AfficheReservations");
    }
    /**
     * @Route("reservation/update/{id}", name="updateReservation")
     */

    function Update(ReservationRepository $repository,Request $request, $id){
        $reservation = $repository->find($id);
        $form = $this->createForm(TerrainType::class, $reservation);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            $this -> addFlash('success', 'Réservation bien modifiée avec succès');

            return $this->redirectToRoute("AfficheReservations");
        }
        return $this->render('reservation/Update.html.twig',['form' => $form->createView()]);
    }


    /**
     * @Route("terrain/reserver/{id}", name="updateTerrain")
     */

    function reserver(TerrainRepository $repository,Request $request, $id){
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

            $this -> addFlash('success', 'Terrain bien réserver avec succès');


        }
        return $this->render('front/terrain/sh.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/reservation", name="reservation")
     */
    public function reservation(ReservationRepository $repository, UtilisateurRepository $uRep)
    {
        $utilisateur = $uRep->find(35);

        $reservations = $repository->findReservation($utilisateur->getEquipe()->getCapitain());
        return $this->render('front/reservation.html.twig', ['reservations' => $reservations,]);
    }

    /**
     * @Route("/reservationp", name="reservationp")
     */
    public function Affichep(ReservationRepository  $repository){

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $reservations = $repository->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('Admin/reservation/reservationsPdf.html.twig', ['reservations' => $reservations]);

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


    /**
     * @Route("/create-checkout-session", name="checkout")
     */
    public function checkout()
    {
        \Stripe\Stripe::setApiKey('sk_test_51Ij35jLfgO63Jzd8Vlp981YwIJaiLu50dex7ACKe8U0pfXyc5380SCgxJxsxR4GnsawwyoVx9HzD3GXHXBc3wp7t00kNDf1hKq');
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'T-shirt',
                    ],
                    'unit_amount' => 2000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('succes', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('echec', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        return new JsonResponse([[ 'id' => $session->id ]]);
    }

    /**
     * @Route("/succes", name="succes")
     */
    public function succes(): Response
    {
        return $this->render('front/paiement/succes.html.twig', [

        ]);
    }

    /**
     * @Route("/echec", name="echec")
     */
    public function echec(): Response
    {
        return $this->render('front/paiement/echec.html.twig', [

        ]);
    }



    /**
     * @Route("/res ", name="res")
     */
    public function res(Request $request , TerrainRepository  $terrainRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $repo=$this->getDoctrine()->getRepository(Utilisateur::class);
        $user = $repo->find(31);
        if($request->isMethod("post"))
        {$terrains = $terrainRepository->findAll();
            $terrain = $terrainRepository->find($request->get('ter'));
            $reservation = new Reservation();
           // $reservation->setTerrain($terrain) ;
           // $reservation->setMontant($terrain.getPrixLocation());
            $reservation->setMontant(22);
            //$date = \DateTime::createFromFormat( $request->get('dat'));
            $date = \DateTime::createFromFormat('Ymd', $request->get('dat'));

            $h = new \DateTime();

            //$h->setTime($v[0],$v[1],$v[2]);


            $h1 =$request->get('h');

            $m = $request->get('m');
            $s = $request->get('s');
            $h->setTime(14,00,00);
            $heure=$h;
            $reservation->setDateReservation($date);
            $reservation->setHeure($heure);
            $reservation->setAcceptee(false);
            $reservation->setDateCreation(new \DateTime());
            $reservation->setTerrain($terrain);
            $reservation->setClient($user);
            $em->persist($reservation);
            $em->flush();
            $this -> addFlash('success', 'Réservation enregistrée avec succès');



        }
        return $this->render('front/terrain.html.twig', ['terrains' => $terrains]);

    }


    /**
     * @Route("/plan", name="plan")
     */
    public function plan(): Response
    {  $repo=$this->getDoctrine()->getRepository(Reservation::class);
        $res=$repo->findAll();
        $rdv=[];
        foreach ($res as $r){
            $rdv []=[
                'id'=>$r->getId(),
                'start'=>$r->getDateReservation()->format('Y-m-d H:i:s'),
                'end'=>$r->getDateReservation()->format('Y-m-d H:i:s'),
                'title'=>$r->getClient()->getNom()

            ];

        }
        $data= json_encode($rdv);
        return $this->render('Admin/Competition/calander.html.twig',compact('data'));
    }


    /**
     * @Route("/confirmer/{id}", name="confirmer")
     */
    public function accepter( \Swift_Mailer $mailer, ReservationRepository $repository, $id)
    {

        $reservation = $repository->find($id);
        $reservation->setValidee(true);
        $em=$this->getDoctrine()->getManager();
        $em->flush();
        /*$text = "Votre réservation a été confirmée";
        $message = (new \Swift_Message('Réservation'))
            ->setFrom('num.20746081@gmail.com')
            ->setTo('punchymistake@mailinator.com')
            ->setBody(
                $this->renderView(
                    'Admin/reservation/confirmation.html.twig', compact('text')
                ),
                'text/html'
            )
        ;
        $mailer->send($message);*/
        $this->addFlash('success', 'Réservation confirmée.');


        return $this->redirectToRoute("Reservations");

    }

}
