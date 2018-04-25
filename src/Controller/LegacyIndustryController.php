<?php

namespace App\Controller;

use App\Entity\LegacyIndustry;
use App\Form\LegacyIndustryType;
use App\Repository\LegacyIndustryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/legacy-industry")
 */
class LegacyIndustryController extends Controller
{
    /**
     * @Route("/", name="legacy_industry_index", methods="GET")
     */
    public function index(LegacyIndustryRepository $legacyIndustryRepository): Response
    {
        return $this->render('legacy_industry/index.html.twig', ['legacy_industries' => $legacyIndustryRepository->findAll()]);
    }

    /**
     * @Route("/new", name="legacy_industry_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $legacyIndustry = new LegacyIndustry();
        $form = $this->createForm(LegacyIndustryType::class, $legacyIndustry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($legacyIndustry);
            $em->flush();

            return $this->redirectToRoute('legacy_industry_index');
        }

        return $this->render('legacy_industry/new.html.twig', [
            'legacy_industry' => $legacyIndustry,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="legacy_industry_show", methods="GET")
     */
    public function show(LegacyIndustry $legacyIndustry): Response
    {
        return $this->render('legacy_industry/show.html.twig', ['legacy_industry' => $legacyIndustry]);
    }

    /**
     * @Route("/{id}/edit", name="legacy_industry_edit", methods="GET|POST")
     */
    public function edit(Request $request, LegacyIndustry $legacyIndustry): Response
    {
        $form = $this->createForm(LegacyIndustryType::class, $legacyIndustry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('legacy_industry_edit', ['id' => $legacyIndustry->getId()]);
        }

        return $this->render('legacy_industry/edit.html.twig', [
            'legacy_industry' => $legacyIndustry,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="legacy_industry_delete", methods="DELETE")
     */
    public function delete(Request $request, LegacyIndustry $legacyIndustry): Response
    {
        if ($this->isCsrfTokenValid('delete'.$legacyIndustry->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($legacyIndustry);
            $em->flush();
        }

        return $this->redirectToRoute('legacy_industry_index');
    }
}
