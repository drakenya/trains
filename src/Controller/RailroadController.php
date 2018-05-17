<?php

namespace App\Controller;

use App\Entity\Railroad;
use App\Form\RailroadType;
use App\Repository\RailroadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/railroad")
 */
class RailroadController extends Controller
{
    /**
     * @Route("/", name="railroad_index", methods="GET")
     */
    public function index(RailroadRepository $railroadRepository): Response
    {
        return $this->render('railroad/index.html.twig', ['railroads' => $railroadRepository->findBy([], ['reportingMark' => 'ASC'])]);
    }

    /**
     * @Route("/new", name="railroad_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $railroad = new Railroad();
        $form = $this->createForm(RailroadType::class, $railroad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($railroad);
            $em->flush();

            return $this->redirectToRoute('railroad_index');
        }

        return $this->render('railroad/new.html.twig', [
            'railroad' => $railroad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="railroad_show", methods="GET")
     */
    public function show(Railroad $railroad): Response
    {
        return $this->render('railroad/show.html.twig', ['railroad' => $railroad]);
    }

    /**
     * @Route("/{id}/edit", name="railroad_edit", methods="GET|POST")
     */
    public function edit(Request $request, Railroad $railroad): Response
    {
        $form = $this->createForm(RailroadType::class, $railroad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('railroad_edit', ['id' => $railroad->getId()]);
        }

        return $this->render('railroad/edit.html.twig', [
            'railroad' => $railroad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="railroad_delete", methods="DELETE")
     */
    public function delete(Request $request, Railroad $railroad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$railroad->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($railroad);
            $em->flush();
        }

        return $this->redirectToRoute('railroad_index');
    }
}
