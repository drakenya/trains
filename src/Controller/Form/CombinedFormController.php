<?php

namespace App\Controller\Form;

use App\Entity\EmptyCarBill;
use App\Entity\FullEmptyCarBill;
use App\Entity\FullWaybill;
use App\Entity\Waybill;
use App\Paperwork\Creator\FullEmptyCarBillCreator;
use App\Paperwork\Creator\FullWaybillFormCreator;
use App\Paperwork\Creator\ShortEmptyCarBillCreator;
use App\Paperwork\Creator\ShortWaybillFormCreator;
use App\Paperwork\Form\EmptyCarBillForm;
use App\Paperwork\Form\WaybillForm;
use App\Paperwork\Page\FullPage;
use App\Paperwork\Page\ShortPage;
use App\Repository\EmptyCarBillRepository;
use App\Repository\FullEmptyCarBillRepository;
use App\Repository\FullWaybillRepository;
use App\Repository\WaybillRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/form/combined")
 */
class CombinedFormController extends Controller
{
    private $fullWaybillRepository;
    private $waybillRepository;
    private $fullWaybillFormCreator;
    private $shortWaybillFormCreator;
    private $fullEmptyCarBillCreator;
    private $shortEmptyCarBillCreator;
    private $fullEmptyCarBillRepository;
    private $emptyCarBillRepository;

    public function __construct(
        FullWaybillFormCreator $fullWaybillFormCreator,
        ShortWaybillFormCreator $shortWaybillFormCreator,
        FullEmptyCarBillCreator $fullEmptyCarBillCreator,
        ShortEmptyCarBillCreator $shortEmptyCarBillCreator,
        FullWaybillRepository $fullWaybillRepository,
        WaybillRepository $waybillRepository,
        FullEmptyCarBillRepository $fullEmptyCarBillRepository,
        EmptyCarBillRepository $emptyCarBillRepository
    )
    {
        $this->fullWaybillRepository = $fullWaybillRepository;
        $this->fullWaybillFormCreator = $fullWaybillFormCreator;
        $this->shortWaybillFormCreator = $shortWaybillFormCreator;
        $this->waybillRepository = $waybillRepository;

        $this->fullEmptyCarBillCreator = $fullEmptyCarBillCreator;
        $this->shortEmptyCarBillCreator = $shortEmptyCarBillCreator;
        $this->fullEmptyCarBillRepository = $fullEmptyCarBillRepository;
        $this->emptyCarBillRepository = $emptyCarBillRepository;
    }

    /**
     * @Route("/full", name="full_combined_form_print")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function fullCombined(Request $request): Response
    {
        if ($request->get('waybills') || $request->get('emptyCarBills')) {
            if ($request->get('waybills') || $request->get('emptyCarBills')) {
                $waybills = $this->fullWaybillRepository->findBy(['id' => explode(',', $request->get('waybills'))]);
            } else {
                $waybills = $this->fullWaybillRepository->findAll();
            }

            if ($request->get('emptyCarBills')) {
                $emptyCarBills = $this->fullEmptyCarBillRepository->findBy(['id' => explode(',', $request->get('emptyCarBills'))]);
            } else {
                $emptyCarBills = $this->fullEmptyCarBillRepository->findAll();
            }
        } else {
            $waybills = $this->fullWaybillRepository->findAll();
            $emptyCarBills = $this->fullEmptyCarBillRepository->findAll();
        }

        $waybillForms = array_map(function (FullWaybill $waybill): WaybillForm {
            return $this->fullWaybillFormCreator->create($waybill);
        }, $waybills);

        $emptyCarBillForms = array_map(function (FullEmptyCarBill $emptyCarBill): EmptyCarBillForm {
            return $this->fullEmptyCarBillCreator->create($emptyCarBill);
        }, $emptyCarBills);

        return $this->render('form/waybill/template.html.twig', [
            'page' => new FullPage(),
            'forms' => array_merge($waybillForms, $emptyCarBillForms),
            'isWebRequest' => (bool) !$request->get('preview'),
        ]);
    }

    /**
     * @Route("/short", name="short_combined_form_print")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function shortCombined(Request $request): Response
    {
        if ($request->get('waybills') || $request->get('emptyCarBills')) {
            if ($request->get('waybills')) {
                $waybills = $this->waybillRepository->findBy(['id' => explode(',', $request->get('waybills'))]);
            } else {
                $waybills = $this->waybillRepository->findAll();
            }

            if ($request->get('emptyCarBills')) {
                $emptyCarBills = $this->emptyCarBillRepository->findBy([
                    'id' => explode(',', $request->get('emptyCarBills'))
                ]);
            } else {
                $emptyCarBills = $this->emptyCarBillRepository->findAll();
            }
        } else {
            $waybills = $this->waybillRepository->findAll();
            $emptyCarBills = $this->emptyCarBillRepository->findAll();
        }

        $waybillForms = array_map(function (Waybill $waybill): WaybillForm {
            return $this->shortWaybillFormCreator->create($waybill);
        }, $waybills);

        $emptyCarBillForms = array_map(function (EmptyCarBill $emptyCarBill): EmptyCarBillForm {
            return $this->shortEmptyCarBillCreator->create($emptyCarBill);
        }, $emptyCarBills);

        return $this->render('form/waybill/template.html.twig', [
            'page' => new ShortPage(),
            'forms' => array_merge($waybillForms, $emptyCarBillForms),
            'isWebRequest' => (bool) !$request->get('preview'),
        ]);
    }
}
