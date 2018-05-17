<?php

namespace App\Controller;

use App\Entity\AarCode;
use App\Form\AarCodeType;
use App\Repository\AarCodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/aar-code")
 */
class AarCodeController extends Controller
{
    /**
     * @Route("/", name="aar_code_index", methods="GET")
     */
    public function index(AarCodeRepository $aarCodeRepository): Response
    {
        return $this->render('aar_code/index.html.twig', ['aar_codes' => $aarCodeRepository->findBy([], ['code' => 'ASC'])]);
    }

    /**
     * @Route("/new", name="aar_code_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $aarCode = new AarCode();
        $form = $this->createForm(AarCodeType::class, $aarCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($aarCode);
            $em->flush();

            return $this->redirectToRoute('aar_code_index');
        }

        return $this->render('aar_code/new.html.twig', [
            'aar_code' => $aarCode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="aar_code_show", methods="GET")
     */
    public function show(AarCode $aarCode): Response
    {
        return $this->render('aar_code/show.html.twig', ['aar_code' => $aarCode]);
    }

    /**
     * @Route("/{id}/edit", name="aar_code_edit", methods="GET|POST")
     */
    public function edit(Request $request, AarCode $aarCode): Response
    {
        $form = $this->createForm(AarCodeType::class, $aarCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('aar_code_edit', ['id' => $aarCode->getId()]);
        }

        return $this->render('aar_code/edit.html.twig', [
            'aar_code' => $aarCode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="aar_code_delete", methods="DELETE")
     */
    public function delete(Request $request, AarCode $aarCode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aarCode->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aarCode);
            $em->flush();
        }

        return $this->redirectToRoute('aar_code_index');
    }
}
