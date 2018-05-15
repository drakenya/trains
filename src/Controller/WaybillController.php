<?php

namespace App\Controller;

use App\Entity\Waybill;
use App\Form\WaybillType;
use App\Repository\WaybillRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/waybill")
 */
class WaybillController extends Controller
{
    private $waybillRepository;
    private $serializer;

    public function __construct(WaybillRepository $waybillRepository, SerializerInterface $serializer)
    {
        $this->waybillRepository = $waybillRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="waybill_index", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('waybill/index.html.twig');
    }

    /**
     * @Route("/api/list", name="waybill_api_list", methods="GET")
     */
    public function apiList(Request $request): JsonResponse
    {
        $data = $this->waybillRepository->getSelection(
            $request->get('page'),
            $request->get('limit'),
            $request->get('orderBy') ?: null,
            strtolower($request->get('sortOrder')) === 'asc',
            $request->get('query') ?: null
        );
        array_walk($data, function (&$item) {
            $item['viewUrl'] = $this->generateUrl('waybill_show', ['id' => $item['id']]);
            $item['editUrl'] = $this->generateUrl('waybill_edit', ['id' => $item['id']]);
        });

        $responseData = [
            'data' => $data,
            'count' => $this->waybillRepository->getRecordCount($request->get('query') ?: null),
        ];

        return new JsonResponse($this->serializer->serialize($responseData, 'json'), 200, [], true);
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
