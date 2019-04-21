<?php

namespace App\Controller;

use App\Entity\Clienti;
use App\Entity\Fatture;
use App\Form\FattureAddForm;
use App\Form\FattureSearchForm;
use App\Repository\FattureRepository;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\FetchMode;
use Mpdf\Mpdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FattureController
 * @package App\Controller
 * @Route("/fatture")
 */
class FattureController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, name="fatture")
     * @Route("/page/{page<[1-9]\d*>}", defaults={"page": "1"}, name="fatture_index_paginated")
     */
    public function index(Request $request, int $page, FattureRepository $fattureRepository)
    {
        $searchForm = $this->createForm(FattureSearchForm::class, []);

        if ($request->query->has('fatture_search_form')) {
            $fatture = $fattureRepository->findFilteredPaginator($page, $request->query->get('fatture_search_form'));
        } else {
            $fatture = $fattureRepository->findLastsPaginator($page);
        }

        return $this->render('fatture/index.html.twig', [
            'controller_name' => 'FattureController',
            'fatture' => $fatture,
            'searchForm' => $searchForm->createView(),
        ]);
    }


    /**
     * @Route("/view/{id<[1-9]\d*>}", name="fatture_view")
     */
    public function viewAction($id, Request $request){

        $em = $this->getDoctrine()->getManager();
        $ft = $em->getRepository(Fatture::class)->find($id);

        if ($request->get('addSpese')==1) {
            $ft->setSpesaincasso(5);
            $em->persist ( $ft );
            $em->flush();
        } elseif ($request->get('addSpese')==0){
            $ft->setSpesaincasso(0);
            $em->persist ( $ft );
            $em->flush();
        }

        return $this->render('fatture/view.html.twig', [
            'ft' => $ft,
        ]);
    }

    /**
     * @Route("/pdf/{id<[1-9]\d*>}", name="fatture_pdf")
     */
    public function pdfAction($id, $mode = null){

        $em = $this->getDoctrine()->getManager();
        $ft = $em->getRepository(Fatture::class)->find($id);

        $html = $this->renderView ( 'fatture/pdf.html.twig',[
                'ft' => $ft,
        ]);

        $mpdf = new Mpdf();

        // Write some HTML code:
        $mpdf->WriteHTML($html);

        // Output a PDF file directly to the browser
        if (!$mode) {
            $mpdf->Output();
        } else {
            $pdffile = $mpdf->Output('test.pdf', \Mpdf\Output\Destination::STRING_RETURN);
            return new Response($pdffile, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf ( 'attachment; filename="prova.pdf"' )
            ]);
        }
    }

    /**
     * @Route("/pdf/lista/{anno}/{mese}", name="fatture_lista_pdf")
     */
    public function listaPdfAction($anno, $mese, Request $request, FattureRepository $fattureRepository){

        $fatture = $fattureRepository->findAnnoMese($anno, $mese);

        $html = $this->renderView ( 'fatture/listapdf.html.twig',[
            'fatture' => $fatture,
            'anno' => $anno,
            'mese' => $mese,
        ]);

        $mpdf = new Mpdf();

        // Write some HTML code:
        $mpdf->WriteHTML($html);

        $mpdf->Output();

    }


    /**
     * @Route("/delete/{id<[1-9]\d*>}", name="fatture_delete")
     */
    public function deleteAction($id){

        $em = $this->getDoctrine()->getManager();
        $ft = $em->getRepository(Fatture::class)->find($id);

        $em->remove($ft);
        $em->flush();

        $this->addFlash('warning', 'Fattura cancellata!!');

        return $this->redirectToRoute('fatture');
    }

    /**
     * @Route("/add", name="fatture_add")
     */
    public function addAction(Request $request, Connection $connection)
    {
        $fattureForm = $this->createForm(FattureAddForm::class, []);

        if (null !== $request->get('fatture_add_form', null)) {
            $data_ft = strtotime($request->get('fatture_add_form')['dataFattura']);
        } elseif (null !== $request->getSession()->get('last_data_ft')){
            $data_ft = strtotime($request->getSession()->get('last_data_ft'));
        } else {
            $data_ft = strtotime("today");
        }

        $sql = "SELECT c.id, c.ragione_sociale, SUM(d.prezzo) as totale " . "FROM ddts d JOIN clienti c ON (d.cliente_id = c.id) " . "WHERE data_ddt <= :data_ft AND fattura_id IS NULL GROUP BY cliente_id " . "ORDER BY totale ASC";
        $stmt = $connection->prepare ( $sql );
        $stmt->execute ( array (
            'data_ft' => date ( 'Y-m-d', $data_ft )
        ) );

        return $this->render('fatture/fatturazione.html.twig', [
            'fatture' => $stmt->fetchAll(),
            'fatturaForm' => $fattureForm->createView(),
            'data_fattura' => $data_ft,
        ]);
    }

    /**
     * @Route("/go/{idcli}/{data_ft}", name="fatturazione")
     */
    public function fatturazione($idcli, $data_ft, Connection $conn, Request $request) {

        //save DataFattura in session
        $request->getSession()->set('last_data_ft',$data_ft);

        $stm = $conn->query("CALL fatturazione($idcli, '$data_ft')");

        $em = $this->getDoctrine ()->getManager ();
        $cliente = $em->getRepository(Clienti::class)->find($idcli);

        $this->addFlash ( 'notice', 'Fatturato cliente: '. $cliente->getRagioneSociale() );

        return $this->redirectToRoute('fatture');

    }

    /**
     * @Route("/mail/{id<[1-9]\d*>}", name="fatture_mail")
     */
    public function mailFatturaAction($id, \Swift_Mailer $mailer, FattureRepository $fattureRepository) {
        $ft = $fattureRepository->find($id);

        // Create your file contents in the normal way, but don't write them to disk
        $data = $this->pdfAction ( $id, 'S' );
        $filename = sprintf ( 'Dettaglio Ft %s Natalini.pdf', $ft->getNumeroFattura () ); //, $ft->getDataFattura ()->format ( 'Ymd' )

        // Create the attachment with your data
        $attachment = new \Swift_Attachment ( $data, $filename, 'application/pdf' );

        $message = (new \Swift_Message ( 'Dettaglio Trasporti rif. ' . $ft->getNumeroFattura () ))
            ->setFrom ( 'noreply@natalinitrasporti.it' )
            ->setTo ( $ft->getCliente ()->getEmail () )
            ->setBcc('info@natalinitrasporti.it')
            ->setBody ( $this->renderView ( 'fatture/email/ft_mail.html.twig', array (
                'ft' => $ft
            ) ), 'text/html' )
            /*
             * If you also want to include a plaintext version of the message
             ->addPart(
             $this->renderView(
             'Emails/registration.txt.twig',
             array('name' => $name)
             ),
             'text/plain'
             )
             */
            ->attach ( $attachment );

        $mailResponse = $mailer->send ( $message );

        // or, you can also fetch the mailer service this way
        // $this->get('mailer')->send($message);

        $dataMail = new \DateTime ( null, new \DateTimeZone ( 'Europe/Rome' ) );
        $ft->setDataMail ( $dataMail );
        $em = $this->getDoctrine ()->getManager ();
        $em->persist ( $ft );
        $em->flush ();

        $this->addFlash ( 'notice', 'Dettaglio ' . $ft->getNumeroFattura() . ' inviato a ' .
            $ft->getCliente ()->getRagioneSociale () . '  (' .$ft->getCliente ()->getEmail (). ')');

        return $this->redirectToRoute ( 'fatture' );
    }

    /**
     * @Route ("/report", name ="fatture_report")
     */
    public function reportAction(Connection $connection){

        $anno = date('Y', strtotime('now'));

        $sql = "select SUM(d.prezzo) as fatturato FROM ddts as d WHERE YEAR(d.data_ddt) = :anno GROUP BY MONTH (d.data_ddt)";
        $stmt = $connection->prepare( $sql );

        $stmt->execute(['anno' => $anno,]);
        $ft1 = $stmt->fetchAll(FetchMode::COLUMN);
        $stmt->execute(['anno' => $anno - 1,]);
        $ft2 = $stmt->fetchAll(FetchMode::COLUMN);
        $stmt->execute(['anno' => $anno - 2,]);
        $ft3 = $stmt->fetchAll(FetchMode::COLUMN);
        $stmt->execute(['anno' => $anno - 3,]);
        $ft4 = $stmt->fetchAll(FetchMode::COLUMN);
        $stmt->execute(['anno' => $anno - 4,]);
        $ft5 = $stmt->fetchAll(FetchMode::COLUMN);

        //dump(date('Y', strtotime('now'))); die;

        return $this->render('fatture/report.html.twig', [
            'ft1' => $ft1, 'label1' => $anno,
            'ft2' => $ft2, 'label2' => $anno-1,
            'ft3' => $ft3, 'label3' => $anno-2,
            'ft4' => $ft4, 'label4' => $anno-3,
            'ft5' => $ft5, 'label5' => $anno-4,
        ]);
    }
}
