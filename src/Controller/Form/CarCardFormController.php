<?php

namespace App\Controller\Form;

use App\Entity\CarCard;
use App\Paperwork\Form\CarCardForm;
use App\Repository\CarCardRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/form/car-card")
 */
class CarCardFormController extends Controller
{
    private $carCardRepository;

    public function __construct(CarCardRepository $carCardRepository)
    {
        $this->carCardRepository = $carCardRepository;
    }

    /**
     * @Route("/", name="car_card_form_print")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function carCard(Request $request)
    {
        $carCards = $this->carCardRepository->findAll();

        $carCardForms = array_map(function (CarCard $carCard) {
            return new CarCardForm($carCard);
        }, $carCards);

        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        return $this->render('form/car_card/print.html.twig', [
            'forms' => $carCardForms,
            'isWebRequest' => (bool) !$request->get('preview'),
        ]);
    }
}
