<?php

namespace App\Controller;

use App\Entity\CarCard;
use App\Form\CarCardType;
use App\Repository\CarCardRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/car-card")
 */
class CarCardController extends Controller
{
    private $carCardRepository;
    private $serializer;

    public function __construct(CarCardRepository $carCardRepository, SerializerInterface $serializer)
    {
        $this->carCardRepository = $carCardRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="car_card_index", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('car_card/index.html.twig');
    }

    /**
     * @Route("/api/list", name="car_card_api_list", methods="GET")
     */
    public function apiList(Request $request): JsonResponse
    {
        $data = $this->carCardRepository->getSelection(
            $request->get('page'),
            $request->get('limit'),
            $request->get('orderBy') ?: null,
            strtolower($request->get('sortOrder')) === 'asc',
            $request->get('query') ?: null
        );
        $data = array_map(function ($item) {
            return array_merge(
                $item[0],
                array_filter($item, function ($key) {
                    return !is_numeric($key);
                    }, ARRAY_FILTER_USE_KEY
                ),
                [
                    'viewUrl' => $this->generateUrl('car_card_show', ['id' => $item[0]['id']]),
                    'editUrl' => $this->generateUrl('car_card_edit', ['id' => $item[0]['id']]),
                    'newWaybillUrl' => $this->generateUrl('full_waybill_new', ['carCardId' => $item[0]['id']]),
                    'newEmptyCarBillUrl' => $this->generateUrl('full_empty_car_bill_new', ['carCardId' => $item[0]['id']]),
                    'waybillSearchUrl' => $this->generateUrl('full_waybill_index', ['carCardSearch' => $item[0]['carNumber']]),
                    'emptyCarBillSearchUrl' => $this->generateUrl('full_empty_car_bill_index', ['carCardSearch' => $item[0]['carNumber']]),
                ]
            );
        }, $data);

        $responseData = [
            'data' => $data,
            'count' => $this->carCardRepository->getRecordCount($request->get('query') ?: null),
        ];

        return new JsonResponse($this->serializer->serialize($responseData, 'json'), 200, [], true);
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
