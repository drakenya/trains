<?php

namespace App\Controller\Form;

use App\Entity\EmptyCarBill;
use App\Entity\FullEmptyCarBill;
use App\Paperwork\Creator\FullEmptyCarBillCreator;
use App\Paperwork\Creator\ShortEmptyCarBillCreator;
use App\Paperwork\Page\FullEmptyCarBillPage;
use App\Paperwork\Page\ShortEmptyCarBillPage;
use App\Repository\EmptyCarBillRepository;
use App\Repository\FullEmptyCarBillRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/form/empty-car-bill")
 */
class EmptyCarBillController extends Controller
{
    private $fullEmptyCarBillRepository;
    private $emptyCarBillRepository;
    private $fullCreator;
    private $shortCreator;

    public function __construct(
        FullEmptyCarBillCreator $fullCreator,
        ShortEmptyCarBillCreator $shortCreator,
        FullEmptyCarBillRepository $fullEmptyCarBillRepository,
        EmptyCarBillRepository $emptyCarBillRepository
    )
    {
        $this->fullEmptyCarBillRepository = $fullEmptyCarBillRepository;
        $this->fullCreator = $fullCreator;
        $this->shortCreator = $shortCreator;
        $this->emptyCarBillRepository = $emptyCarBillRepository;
    }

    /**
     * @Route("/full", name="full_empty_car_bill_form_print")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function fullEmptyCarBill(Request $request): Response
    {
        if ($request->get('emptyCarBills')) {
            $emptyCarBills = $this->fullEmptyCarBillRepository->findBy(['id' => explode(',', $request->get('emptyCarBills'))]);
        } else {
            $emptyCarBills = $this->fullEmptyCarBillRepository->findAll();
        }

        $emptyCarBillForms = array_map(function (FullEmptyCarBill $emptyCarBill) {
            return $this->fullCreator->create($emptyCarBill);
        }, $emptyCarBills);

        return $this->render('form/empty_car_bill/template.html.twig', [
            'page' => new FullEmptyCarBillPage(),
            'forms' => $emptyCarBillForms,
            'isWebRequest' => (bool) !$request->get('preview'),
        ]);
    }

    /**
     * @Route("/short", name="short_empty_car_bill_form_print")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function shortEmptyCarBill(Request $request): Response
    {
        if ($request->get('emptyCarBills')) {
            $emptyCarBills = $this->emptyCarBillRepository->findBy(['id' => explode(',', $request->get('emptyCarBills'))]);
        } else {
            $emptyCarBills = $this->emptyCarBillRepository->findAll();
        }

        $emptyCarBillForms = array_map(function (EmptyCarBill $emptyCarBill) {
            return $this->shortCreator->create($emptyCarBill);
        }, $emptyCarBills);

        return $this->render('form/empty_car_bill/template.html.twig', [
            'page' => new ShortEmptyCarBillPage(),
            'forms' => $emptyCarBillForms,
            'isWebRequest' => (bool) !$request->get('preview'),
        ]);
    }
}
