<?php

namespace App\Controller;

use App\Entity\Ddts;
use App\Form\DdtEditForm;
use App\Form\DdtSearchForm;
use App\Repository\ClientiRepository;
use App\Repository\DdtsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DdtsController
 * @package App\Controller
 * @Route("/ddts")
 */
class DdtsController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, name="ddts")
     * @Route("/page/{page<[1-9]\d*>}", defaults={"page": "1"}, name="ddts_index_paginated")
     */
    public function index(Request $request, int $page, DdtsRepository $ddtsRepository)
    {

        $form = $this->createForm(DdtSearchForm::class, []);

        if ($request->query->has('ddt_search_form')) {
            $ddts = $ddtsRepository->findFilteredPaginator($page, $request->query->get('ddt_search_form'));
        } elseif ($request->query->has('automezzo')){
            $id = $request->query->get('automezzo');
            $anno= $request->query->get('anno');
            $mese = $request->query->get('mese');
            $ddts = $ddtsRepository->findDtdAutomezzo($page, $id, $anno, $mese);
        } elseif($request->query->has('data_ft')) {
            $data_ft = $request->query->get('data_ft');
            $idcli = $request->query->get('cliente');
            $ddts = $ddtsRepository->findDdtFatturabili($page, $idcli, $data_ft);
        } else {
            $ddts = $ddtsRepository->findLastsPaginator($page);
        }

        return $this->render('ddts/index.html.twig', [
            'controller_name' => 'DdtsController',
            'ddts' => $ddts,
            'searchForm' => $form->createView(),
        ]);
    }


    /**
     * @Route("/add", name="ddts_add")
     * @Route("/edit/{id<[1-9]\d*>}", name="ddts_edit")
     */
    public function addAction(Request $request, $id = null, DdtsRepository $ddtsRepository){

        if (!$id) {
            $ddt = new Ddts();
            $request->getSession()->set('last_referer', null);
        } else {
            $ddt = $ddtsRepository->find($id);
            //save Automezzo in session
            $request->getSession()->set('last_mezzo', null);
        }

        $form = $this->createForm(DdtEditForm::class, $ddt);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $ddt = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ddt);
            $entityManager->flush();

            //save Automezzo in session
            $request->getSession()->set('last_mezzo',$ddt->getAutomezzo()->getId());

            $this->addFlash('success', 'DDT salvato: '.$ddt->getCliente()->getRagioneSociale());

            if (null !== $request->getSession()->get('last_referer')){
                return $this->redirect($request->getSession()->get('last_referer'));
            } else {
                return $this->redirectToRoute('ddts_add');
            }

        }

        $request->getSession()->set('last_referer', $request->headers->get('referer'));

        return $this->render('ddts/add.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/delete/{id<[1-9]\d*>}", name="ddts_delete")
     */
    public function deleteAction($id){

        $em = $this->getDoctrine()->getManager();
        $ddt = $em->getRepository(Ddts::class)->find($id);

        $em->remove($ddt);
        $em->flush();

        $this->addFlash('warning', 'DDT cancellato!!');

        return $this->redirectToRoute('ddts');
    }
}
