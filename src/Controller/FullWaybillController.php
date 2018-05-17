<?php

namespace App\Controller;

use App\Entity\FullWaybill;
use App\Form\FullWaybillType;
use App\Repository\FullWaybillRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/full-waybill")
 */
class FullWaybillController extends Controller
{
    private $fullWaybillRepository;
    private $serializer;

    public function __construct(FullWaybillRepository $fullWaybillRepository, SerializerInterface $serializer)
    {
        $this->fullWaybillRepository = $fullWaybillRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="full_waybill_index", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('full_waybill/index.html.twig');
    }

    /**
     * @Route("/api/list", name="full_waybill_api_list", methods="GET")
     */
    public function apiList(Request $request): JsonResponse
    {
        $data = $this->fullWaybillRepository->getSelection(
            $request->get('page'),
            $request->get('limit'),
            $request->get('orderBy') ?: null,
            strtolower($request->get('sortOrder')) === 'asc',
            $request->get('query') ?: null
        );
        array_walk($data, function (&$item) {
            $item['viewUrl'] = $this->generateUrl('full_waybill_show', ['id' => $item['id']]);
            $item['editUrl'] = $this->generateUrl('full_waybill_edit', ['id' => $item['id']]);
        });

        $responseData = [
            'data' => $data,
            'count' => $this->fullWaybillRepository->getRecordCount($request->get('query') ?: null),
        ];

        return new JsonResponse($this->serializer->serialize($responseData, 'json'), 200, [], true);
    }

    /**
     * @Route("/new", name="full_waybill_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $fullWaybill = new FullWaybill();
        $form = $this->createForm(FullWaybillType::class, $fullWaybill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fullWaybill);
            $em->flush();

            return $this->redirectToRoute('full_waybill_index');
        }

        return $this->render('full_waybill/new.html.twig', [
            'full_waybill' => $fullWaybill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="full_waybill_show", methods="GET")
     */
    public function show(FullWaybill $fullWaybill): Response
    {
        return $this->render('full_waybill/show.html.twig', ['full_waybill' => $fullWaybill]);
    }

    /**
     * @Route("/{id}/edit", name="full_waybill_edit", methods="GET|POST")
     */
    public function edit(Request $request, FullWaybill $fullWaybill): Response
    {
        $form = $this->createForm(FullWaybillType::class, $fullWaybill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('full_waybill_edit', ['id' => $fullWaybill->getId()]);
        }

        return $this->render('full_waybill/edit.html.twig', [
            'full_waybill' => $fullWaybill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="full_waybill_delete", methods="DELETE")
     */
    public function delete(Request $request, FullWaybill $fullWaybill): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fullWaybill->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fullWaybill);
            $em->flush();
        }

        return $this->redirectToRoute('full_waybill_index');
    }
}
