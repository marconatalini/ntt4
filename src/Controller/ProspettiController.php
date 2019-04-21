<?php

namespace App\Controller;

use App\Form\ProspettiSearchForm;
use Doctrine\DBAL\Driver\Connection;
use Mpdf\Mpdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProspettiController
 * @package App\Controller
 * @Route("/prospetti")
 */
class ProspettiController extends AbstractController
{
    /**
     * @Route("/", name="prospetti")
     */
    public function index(Request $request, Connection $connection)
    {
        $form = $this->createForm(ProspettiSearchForm::class, []);

        $form->handleRequest($request);

        if (null !== $request->get('prospetti_search_form', null)) {
            $anno = $request->get('prospetti_search_form')['anno'];
            $sql = "select min(d.id) as id, d.data_ddt, month(d.data_ddt) as mese, d.numero_ddt, c.ragione_sociale, p.sigla from ddts d right outer join (clienti c right join province p on c.provincia_id = p.id) on (d.cliente_id = c.id) " .
                "where d.fattura_id is not null and Weekday(data_ddt)<6 and d.numero_ddt is not null " .
                "group by data_ddt having (year(data_ddt)= :anno) order by data_ddt";
            $stmt = $connection->prepare($sql);
            $stmt->execute(array(
                'anno' => $anno,
            ));
            if ($form->get('estrai')->isClicked()) {
                return $this->render('prospetti/index.html.twig', [
                    'result' => $stmt->fetchAll(),
                    'anno' => $anno,
                    'prospettiForm' => $form->createView(),
                ]);
            } else {
                $html = $this->renderView('prospetti/pdf.html.twig', [
                    'result' => $stmt->fetchAll(),
                    'anno' => $anno,
                ]);

                $mpdf = new Mpdf();

                // Write some HTML code:
                $mpdf->WriteHTML($html);
                $mpdf->Output();
            }
        }

        return $this->render('prospetti/index.html.twig', [
            'result' => null,
            'prospettiForm' => $form->createView(),
        ]);
    }
}
