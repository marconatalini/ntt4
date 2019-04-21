<?php

namespace App\Controller;

use App\Repository\AutomezziRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AutomezziRepository $automezziRepository)
    {
        //verifico le scadenze sui camion
        $result = $automezziRepository->findScadenze();

        $dataBollo = new \DateTime($result[0][1]);
        $ggAlBollo = date_diff($dataBollo, new \DateTime('now'))->format('%a');
        $dataRevisione = new \DateTime($result[0][2]);
        $ggAllaRevisione= date_diff($dataRevisione, new \DateTime('now'))->format('%a');


        $this->addFlash('info', 'Scadenza prossimo BOLLO al '. $dataBollo->format('d-m-Y') . ' fra '. $ggAlBollo . ' giorni');
        $this->addFlash('info', 'Scadenza prossima REVISIONE al '. $dataRevisione->format('d-m-Y') . ' fra '. $ggAllaRevisione. ' giorni');

        return $this->render('default/index.html.twig', []);
    }
}
