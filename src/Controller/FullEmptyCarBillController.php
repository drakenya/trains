<?php

namespace App\Controller;

use App\Entity\FullEmptyCarBill;
use App\Form\FullEmptyCarBillType;
use App\Repository\FullEmptyCarBillRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/full-empty-car-bill")
 */
class FullEmptyCarBillController extends Controller
{
    private $fullEmptyCarBillRepository;
    private $serializer;

    public function __construct(FullEmptyCarBillRepository $fullEmptyCarBillRepository, SerializerInterface $serializer)
    {
        $this->fullEmptyCarBillRepository = $fullEmptyCarBillRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="full_empty_car_bill_index", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('full_empty_car_bill/index.html.twig');
    }

    /**
     * @Route("/api/list", name="full_empty_card_bill_api_list", methods="GET")
     */
    public function apiList(Request $request): JsonResponse
    {
        $data = $this->fullEmptyCarBillRepository->getSelection(
            $request->get('page'),
            $request->get('limit'),
            $request->get('orderBy') ?: null,
            strtolower($request->get('sortOrder')) === 'asc',
            $request->get('query') ?: null
        );
        array_walk($data, function (&$item) {
            $item['viewUrl'] = $this->generateUrl('full_empty_car_bill_show', ['id' => $item['id']]);
            $item['editUrl'] = $this->generateUrl('full_empty_car_bill_edit', ['id' => $item['id']]);
        });

        $responseData = [
            'data' => $data,
            'count' => $this->fullEmptyCarBillRepository->getRecordCount($request->get('query') ?: null),
        ];

        return new JsonResponse($this->serializer->serialize($responseData, 'json'), 200, [], true);
    }

    /**
     * @Route("/new", name="full_empty_car_bill_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $fullEmptyCarBill = new FullEmptyCarBill();
        $form = $this->createForm(FullEmptyCarBillType::class, $fullEmptyCarBill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fullEmptyCarBill);
            $em->flush();

            return $this->redirectToRoute('full_empty_car_bill_index');
        }

        return $this->render('full_empty_car_bill/new.html.twig', [
            'full_empty_car_bill' => $fullEmptyCarBill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="full_empty_car_bill_show", methods="GET")
     */
    public function show(FullEmptyCarBill $fullEmptyCarBill): Response
    {
        return $this->render('full_empty_car_bill/show.html.twig', ['full_empty_car_bill' => $fullEmptyCarBill]);
    }

    /**
     * @Route("/{id}/edit", name="full_empty_car_bill_edit", methods="GET|POST")
     */
    public function edit(Request $request, FullEmptyCarBill $fullEmptyCarBill): Response
    {
        $form = $this->createForm(FullEmptyCarBillType::class, $fullEmptyCarBill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('full_empty_car_bill_edit', ['id' => $fullEmptyCarBill->getId()]);
        }

        return $this->render('full_empty_car_bill/edit.html.twig', [
            'full_empty_car_bill' => $fullEmptyCarBill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="full_empty_car_bill_delete", methods="DELETE")
     */
    public function delete(Request $request, FullEmptyCarBill $fullEmptyCarBill): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fullEmptyCarBill->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fullEmptyCarBill);
            $em->flush();
        }

        return $this->redirectToRoute('full_empty_car_bill_index');
    }
}
