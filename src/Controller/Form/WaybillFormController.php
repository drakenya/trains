<?php

namespace App\Controller\Form;

use App\Entity\Waybill;
use App\Paperwork\Form\WaybillForm;
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
    private $waybillRepository;

    public function __construct(WaybillRepository $waybillRepository)
    {
        $this->waybillRepository = $waybillRepository;
    }

    /**
     * @Route("/", name="waybill_form_print")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function waybill(Request $request): Response
    {
        if ($request->get('waybills')) {
            $waybills = $this->waybillRepository->findBy(['id' => explode(',', $request->get('waybills'))]);
        } else {
            $waybills = $this->waybillRepository->findAll();
        }

        $waybillForms = array_map(function (Waybill $waybill) {
            return new WaybillForm($waybill);
        }, $waybills);

        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        return $this->render('pdf/template.html.twig', [
            'forms' => $waybillForms,
            'isWebRequest' => (bool) !$request->get('preview'),
        ]);
    }
}
