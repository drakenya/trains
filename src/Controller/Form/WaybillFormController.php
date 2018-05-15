<?php

namespace App\Controller\Form;

use App\Entity\CarCardAndWaybill;
use App\Entity\Waybill;
use App\Paperwork\Creator\FullWaybillFormCreator;
use App\Paperwork\Creator\ShortWaybillFormCreator;
use App\Paperwork\Page\ShortWaybillPage;
use App\Paperwork\Page\FullWaybillPage;
use App\Repository\CarCardAndWaybillRepository;
use App\Repository\WaybillRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/form/waybill")
 */
class WaybillFormController extends Controller
{
    private $carCardAndWaybillRepository;
    private $waybillRepository;
    private $fullCreator;
    private $shortCreator;

    public function __construct(
        FullWaybillFormCreator $fullCreator,
        ShortWaybillFormCreator $shortCreator,
        CarCardAndWaybillRepository $carCardAndWaybillRepository,
        WaybillRepository $waybillRepository
    )
    {
        $this->carCardAndWaybillRepository = $carCardAndWaybillRepository;
        $this->fullCreator = $fullCreator;
        $this->shortCreator = $shortCreator;
        $this->waybillRepository = $waybillRepository;
    }

    /**
     * @Route("/full", name="full_waybill_form_print")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function fullWaybill(Request $request): Response
    {
        if ($request->get('waybills')) {
            $waybills = $this->carCardAndWaybillRepository->findBy(['id' => explode(',', $request->get('waybills'))]);
        } else {
            $waybills = $this->carCardAndWaybillRepository->findAll();
        }

        $waybillForms = array_map(function (CarCardAndWaybill $waybill) {
            return $this->fullCreator->create($waybill);
        }, $waybills);

        return $this->render('form/waybill/template.html.twig', [
            'page' => new FullWaybillPage(),
            'forms' => $waybillForms,
            'isWebRequest' => (bool) !$request->get('preview'),
        ]);
    }

    /**
     * @Route("/short", name="short_waybill_form_print")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function shortWaybill(Request $request): Response
    {
        if ($request->get('waybills')) {
            $waybills = $this->waybillRepository->findBy(['id' => explode(',', $request->get('waybills'))]);
        } else {
            $waybills = $this->waybillRepository->findAll();
        }

        $waybillForms = array_map(function (Waybill $waybill) {
            return $this->shortCreator->create($waybill);
        }, $waybills);

        return $this->render('form/waybill/template.html.twig', [
            'page' => new ShortWaybillPage(),
            'forms' => $waybillForms,
            'isWebRequest' => (bool) !$request->get('preview'),
        ]);
    }
}
