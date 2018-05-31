<?php

namespace App\Controller;

use App\Entity\EmptyCarBill;
use App\Form\EmptyCarBillType;
use App\Repository\EmptyCarBillRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/empty-car-bill")
 */
class EmptyCarBillController extends Controller
{
    private $emptyCarBillRepository;
    private $serializer;

    public function __construct(EmptyCarBillRepository $emptyCarBillRepository, SerializerInterface $serializer)
    {
        $this->emptyCarBillRepository = $emptyCarBillRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="empty_car_bill_index", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('empty_car_bill/index.html.twig');
    }

    /**
     * @Route("/api/list", name="empty_card_bill_api_list", methods="GET")
     */
    public function apiList(Request $request): JsonResponse
    {
        $data = $this->emptyCarBillRepository->getSelection(
            $request->get('page'),
            $request->get('limit'),
            $request->get('orderBy') ?: null,
            strtolower($request->get('sortOrder')) === 'asc',
            $request->get('query') ?: null
        );
        array_walk($data, function (&$item) {
            $item['viewUrl'] = $this->generateUrl('empty_car_bill_show', ['id' => $item['id']]);
            $item['editUrl'] = $this->generateUrl('empty_car_bill_edit', ['id' => $item['id']]);
        });

        $responseData = [
            'data' => $data,
            'count' => $this->emptyCarBillRepository->getRecordCount($request->get('query') ?: null),
        ];

        return new JsonResponse($this->serializer->serialize($responseData, 'json'), 200, [], true);
    }

    /**
     * @Route("/new", name="empty_car_bill_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $emptyCarBill = new EmptyCarBill();
        $form = $this->createForm(EmptyCarBillType::class, $emptyCarBill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($emptyCarBill);
            $em->flush();

            return $this->redirectToRoute('empty_car_bill_index');
        }

        return $this->render('empty_car_bill/new.html.twig', [
            'empty_car_bill' => $emptyCarBill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="empty_car_bill_show", methods="GET")
     */
    public function show(EmptyCarBill $emptyCarBill): Response
    {
        return $this->render('empty_car_bill/show.html.twig', ['empty_car_bill' => $emptyCarBill]);
    }

    /**
     * @Route("/{id}/edit", name="empty_car_bill_edit", methods="GET|POST")
     */
    public function edit(Request $request, EmptyCarBill $emptyCarBill): Response
    {
        $form = $this->createForm(EmptyCarBillType::class, $emptyCarBill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('empty_car_bill_edit', ['id' => $emptyCarBill->getId()]);
        }

        return $this->render('empty_car_bill/edit.html.twig', [
            'empty_car_bill' => $emptyCarBill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="empty_car_bill_delete", methods="DELETE")
     */
    public function delete(Request $request, EmptyCarBill $emptyCarBill): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emptyCarBill->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($emptyCarBill);
            $em->flush();
        }

        return $this->redirectToRoute('empty_car_bill_index');
    }
}
