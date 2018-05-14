<?php

namespace App\Controller\Form;

use App\Entity\CarCardAndWaybill;
use App\Entity\Waybill;
use App\Paperwork\Creator\WaybillFormCreator;
use App\Paperwork\Form\WaybillForm;
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
    private $creator;

    public function __construct(WaybillFormCreator $creator, CarCardAndWaybillRepository $carCardAndWaybillRepository, WaybillRepository $waybillRepository)
    {
        $this->carCardAndWaybillRepository = $carCardAndWaybillRepository;
        $this->creator = $creator;
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
            return $this->creator->create($waybill);
        }, $waybills);

        if ($this->container->has('profiler'))
        {
//            $this->container->get('profiler')->disable();
        }
        dump($waybillForms[0]);

        return $this->render('form/full_waybill/template.html.twig', [
            'forms' => $waybillForms,
            'isWebRequest' => (bool) !$request->get('preview'),
        ]);
    }
}
