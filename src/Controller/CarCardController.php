<?php

namespace App\Controller;

use App\Entity\CarCard;
use App\Form\CarCardType;
use App\Repository\CarCardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/car-card")
 */
class CarCardController extends Controller
{
    /**
     * @Route("/", name="car_card_index", methods="GET")
     */
    public function index(CarCardRepository $carCardRepository): Response
    {
        return $this->render('car_card/index.html.twig', ['car_cards' => $carCardRepository->findAll()]);
    }

    /**
     * @Route("/new", name="car_card_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $carCard = new CarCard();
        $form = $this->createForm(CarCardType::class, $carCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carCard);
            $em->flush();

            return $this->redirectToRoute('car_card_index');
        }

        return $this->render('car_card/new.html.twig', [
            'car_card' => $carCard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="car_card_show", methods="GET")
     */
    public function show(CarCard $carCard): Response
    {
        return $this->render('car_card/show.html.twig', ['car_card' => $carCard]);
    }

    /**
     * @Route("/{id}/edit", name="car_card_edit", methods="GET|POST")
     */
    public function edit(Request $request, CarCard $carCard): Response
    {
        $form = $this->createForm(CarCardType::class, $carCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_card_edit', ['id' => $carCard->getId()]);
        }

        return $this->render('car_card/edit.html.twig', [
            'car_card' => $carCard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="car_card_delete", methods="DELETE")
     */
    public function delete(Request $request, CarCard $carCard): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carCard->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($carCard);
            $em->flush();
        }

        return $this->redirectToRoute('car_card_index');
    }
}
