<?php

namespace App\Controller\Form;

use App\Entity\FullWaybill;
use App\Entity\Waybill;
use App\Paperwork\Creator\FullWaybillFormCreator;
use App\Paperwork\Creator\ShortWaybillFormCreator;
use App\Paperwork\Page\FullPage;
use App\Paperwork\Page\ShortPage;
use App\Repository\FullWaybillRepository;
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
    private $fullWaybillRepository;
    private $waybillRepository;
    private $fullCreator;
    private $shortCreator;

    public function __construct(
        FullWaybillFormCreator $fullCreator,
        ShortWaybillFormCreator $shortCreator,
        FullWaybillRepository $fullWaybillRepository,
        WaybillRepository $waybillRepository
    )
    {
        $this->fullWaybillRepository = $fullWaybillRepository;
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
            $waybills = $this->fullWaybillRepository->findBy(['id' => explode(',', $request->get('waybills'))]);
        } else {
            $waybills = $this->fullWaybillRepository->findAll();
        }

        $waybillForms = array_map(function (FullWaybill $waybill) {
            return $this->fullCreator->create($waybill);
        }, $waybills);

        return $this->render('form/waybill/template.html.twig', [
            'page' => new FullPage(),
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
            'page' => new ShortPage(),
            'forms' => $waybillForms,
            'isWebRequest' => (bool) !$request->get('preview'),
        ]);
    }
}
