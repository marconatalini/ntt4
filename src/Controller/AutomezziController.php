<?php

namespace App\Controller;

use App\Entity\Automezzi;
use App\Form\AutomezziEditForm;
use App\Form\ReportSearchForm;
use App\Repository\AutomezziRepository;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AutomezziController
 * @package App\Controller
 * @Route("/automezzi")
 */
class AutomezziController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, name="automezzi")
     */
    public function index(int $page, AutomezziRepository $automezziRepository)
    {
        $automezzi = $automezziRepository->findAllPaginator($page);
        return $this->render('automezzi/index.html.twig', [
            'controller_name' => 'AutomezziController',
            'automezzi' => $automezzi,
        ]);
    }

    /**
     * @Route("/add", name="automezzi_add")
     * @Route("/edit/{id<[1-9]\d*>}", name="automezzi_edit")
     */
    public function addAction(Request $request, $id = null, AutomezziRepository $automezziRepository){

        if (!$id) {
            $mezzo = new Automezzi();
        } else {
            $mezzo = $automezziRepository->find($id);
        }

        $form = $this->createForm(AutomezziEditForm::class, $mezzo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $mezzo = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mezzo);
            $entityManager->flush();

            $this->addFlash('success', 'Automezzo salvato: '.$mezzo->getTarga());

            return $this->redirectToRoute('automezzi');
        }

        return $this->render('automezzi/add.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/delete/{id<[1-9]\d*>}", name="automezzi_delete")
     */
    public function deleteAction($id){

        $em = $this->getDoctrine()->getManager();
        $mezzo = $em->getRepository(Automezzi::class)->find($id);
        $targa = $mezzo->getTarga();

        try {
            $em->remove($mezzo);
            $em->flush();
            $this->addFlash('warning', 'Automezzo targato '.$targa.' cancellato!!');
        } catch (ForeignKeyConstraintViolationException $e) {
            $this->addFlash('danger', 'ERRORE: ci sono DDT già inseriti.');
        }

        return $this->redirectToRoute('automezzi');
    }

    /**
     * @Route("/report", name="automezzi_report")
     */
    public function reportAction(Request $request, Connection $connection){

        $form = $this->createForm(ReportSearchForm::class, []);
        $result = null;
        $anno = null;
        $mese = null;

        if (null !== $request->get('report_search_form')) {
            $anno = $request->get('report_search_form')['anno'];
            $mese = $request->get('report_search_form')['mese'];
            if ("" !== $mese) {
                $sql = "select a.id, year(d.data_ddt) as anno, month(d.data_ddt) as mese, a.targa, a.modello, count(d.id) as numeroViaggi, sum(d.prezzo) as totale " .
                    "from ddts d join automezzi a on (d.automezzo_id = a.id) " .
                    "where year(d.data_ddt) = :anno and month(d.data_ddt) = :mese group by d.automezzo_id";

                $stmt = $connection->prepare( $sql );
                $stmt->execute ( array (
                    'anno' => $anno,
                    'mese' => $mese
                ));
            } else {
                $sql = "select a.id, year(d.data_ddt) as anno, month(d.data_ddt) as mese, a.targa, a.modello, count(d.id) as numeroViaggi, sum(d.prezzo) as totale " .
                    "from ddts d join automezzi a on (d.automezzo_id = a.id) " .
                    "where year(d.data_ddt) = :anno group by d.automezzo_id";

                $stmt = $connection->prepare ( $sql );
                $stmt->execute ( array (
                    'anno' => $anno,
                ) );
            }

            $result = $stmt->fetchAll();
        }



        return $this->render('automezzi/report.html.twig', [
            'searchForm' => $form->createView(),
            'result' => $result,
            'anno' => $anno,
            'mese' => $mese,

        ]);
    }
}
