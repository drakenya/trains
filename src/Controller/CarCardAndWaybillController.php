<?php

namespace App\Controller;

use App\Entity\CarCardAndWaybill;
use App\Form\CarCardAndWaybillType;
use App\Repository\CarCardAndWaybillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/car-card-and-waybill")
 */
class CarCardAndWaybillController extends Controller
{
    /**
     * @Route("/", name="car_card_and_waybill_index", methods="GET")
     */
    public function index(CarCardAndWaybillRepository $carCardAndWaybillRepository): Response
    {
        return $this->render('car_card_and_waybill/index.html.twig', ['car_card_and_waybills' => $carCardAndWaybillRepository->findAll()]);
    }

    /**
     * @Route("/new", name="car_card_and_waybill_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $carCardAndWaybill = new CarCardAndWaybill();
        $form = $this->createForm(CarCardAndWaybillType::class, $carCardAndWaybill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carCardAndWaybill);
            $em->flush();

            return $this->redirectToRoute('car_card_and_waybill_index');
        }

        return $this->render('car_card_and_waybill/new.html.twig', [
            'car_card_and_waybill' => $carCardAndWaybill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="car_card_and_waybill_show", methods="GET")
     */
    public function show(CarCardAndWaybill $carCardAndWaybill): Response
    {
        return $this->render('car_card_and_waybill/show.html.twig', ['car_card_and_waybill' => $carCardAndWaybill]);
    }

    /**
     * @Route("/{id}/edit", name="car_card_and_waybill_edit", methods="GET|POST")
     */
    public function edit(Request $request, CarCardAndWaybill $carCardAndWaybill): Response
    {
        $form = $this->createForm(CarCardAndWaybillType::class, $carCardAndWaybill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_card_and_waybill_edit', ['id' => $carCardAndWaybill->getId()]);
        }

        return $this->render('car_card_and_waybill/edit.html.twig', [
            'car_card_and_waybill' => $carCardAndWaybill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="car_card_and_waybill_delete", methods="DELETE")
     */
    public function delete(Request $request, CarCardAndWaybill $carCardAndWaybill): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carCardAndWaybill->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($carCardAndWaybill);
            $em->flush();
        }

        return $this->redirectToRoute('car_card_and_waybill_index');
    }
}
