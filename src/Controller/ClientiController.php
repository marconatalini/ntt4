<?php

namespace App\Controller;

use App\Entity\Clienti;
use App\Form\ClientiEditForm;
use App\Form\ClientiSearchForm;
use App\Repository\ClientiRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ClientiController
 * @package App\Controller
 * @Route("/clienti")
 */
class ClientiController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, name="clienti")
     * @Route("/page/{page<[1-9]\d*>}", defaults={"page": "1"}, name="clienti_index_paginated")
     */
    public function index(Request $request, int $page, ClientiRepository $clientiRepository)
    {
        $form = $this->createForm(ClientiSearchForm::class, []);

        if ($request->query->has('clienti_search_form')) {
            $clienti = $clientiRepository->findFilteredPaginator($page, $request->query->get('clienti_search_form'));
        } else {
            $clienti = $clientiRepository->findAllPaginator($page);
        }

        return $this->render('clienti/index.html.twig', [
            'controller_name' => 'ClientiController',
            'clienti' => $clienti,
            'searchForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/add", name="clienti_add")
     * @Route("/edit/{id<[1-9]\d*>}", name="clienti_edit")
     */
    public function addAction(Request $request, $id = null, ClientiRepository $clientiRepository){

        if (!$id) {
            $cliente = new Clienti();
        } else {
            $cliente = $clientiRepository->find($id);
        }

        $form = $this->createForm(ClientiEditForm::class, $cliente);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $cliente = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cliente);
            $entityManager->flush();

            $this->addFlash('success', 'Cliente salvato: '.$cliente->getRagioneSociale());

            return $this->redirectToRoute('clienti');
        }

        return $this->render('clienti/add.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/delete/{id<[1-9]\d*>}", name="clienti_delete")
     */
    public function deleteAction($id){

        $em = $this->getDoctrine()->getManager();
        $ddt = $em->getRepository(Clienti::class)->find($id);
        $ragioneSociale = $ddt->getRagioneSociale();

        try {
            $em->remove($ddt);
            $em->flush();
            $this->addFlash('warning', 'Cliente '.$ragioneSociale.' cancellato!!');
        } catch (ForeignKeyConstraintViolationException $e) {
            $this->addFlash('danger', 'ERRORE: ci sono DDT già inseriti.');
        }

        return $this->redirectToRoute('clienti');
    }

    /**
     * @Route("/nota/{id<[1-9]\d*>}", name="clienti_nota")
     */
    public function notaClienteAction($id, ClientiRepository $clientiRepository)
    {
        $cliente = $clientiRepository->find($id);

        return $this->render('clienti/nota.html.twig', [
            'cliente' => $cliente
        ]);

    }
}
