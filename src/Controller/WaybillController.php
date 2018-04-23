<?php

namespace App\Controller;

use App\Entity\Waybill;
use App\Form\WaybillType;
use App\Repository\WaybillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/waybill")
 */
class WaybillController extends Controller
{
    /**
     * @Route("/", name="waybill_index", methods="GET")
     */
    public function index(WaybillRepository $waybillRepository): Response
    {
        return $this->render('waybill/index.html.twig', ['waybills' => $waybillRepository->findAll()]);
    }

    /**
     * @Route("/new", name="waybill_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $waybill = new Waybill();
        $form = $this->createForm(WaybillType::class, $waybill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($waybill);
            $em->flush();

            return $this->redirectToRoute('waybill_index');
        }

        return $this->render('waybill/new.html.twig', [
            'waybill' => $waybill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="waybill_show", methods="GET")
     */
    public function show(Waybill $waybill): Response
    {
        return $this->render('waybill/show.html.twig', ['waybill' => $waybill]);
    }

    /**
     * @Route("/{id}/edit", name="waybill_edit", methods="GET|POST")
     */
    public function edit(Request $request, Waybill $waybill): Response
    {
        $form = $this->createForm(WaybillType::class, $waybill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('waybill_edit', ['id' => $waybill->getId()]);
        }

        return $this->render('waybill/edit.html.twig', [
            'waybill' => $waybill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="waybill_delete", methods="DELETE")
     */
    public function delete(Request $request, Waybill $waybill): Response
    {
        if ($this->isCsrfTokenValid('delete'.$waybill->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($waybill);
            $em->flush();
        }

        return $this->redirectToRoute('waybill_index');
    }
}
