<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/magical/irwin')]
class MagicalIRWINController extends AbstractController
{
    #[Route('/', name: 'app_magical_i_r_w_i_n_index', methods: ['GET'])]
    public function index(WishRepository $wishRepository): Response
    {
        return $this->render('magical_irwin/index.html.twig', [
            'wishes' => $wishRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_magical_i_r_w_i_n_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WishRepository $wishRepository): Response
    {
        $wish = new Wish();
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wishRepository->save($wish, true);

            return $this->redirectToRoute('app_magical_i_r_w_i_n_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('magical_irwin/new.html.twig', [
            'wish' => $wish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_magical_i_r_w_i_n_show', methods: ['GET'])]
    public function show(Wish $wish): Response
    {
        return $this->render('magical_irwin/show.html.twig', [
            'wish' => $wish,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_magical_i_r_w_i_n_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Wish $wish, WishRepository $wishRepository): Response
    {
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wishRepository->save($wish, true);

            return $this->redirectToRoute('app_magical_i_r_w_i_n_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('magical_irwin/edit.html.twig', [
            'wish' => $wish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_magical_i_r_w_i_n_delete', methods: ['POST'])]
    public function delete(Request $request, Wish $wish, WishRepository $wishRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wish->getId(), $request->request->get('_token'))) {
            $wishRepository->remove($wish, true);
        }

        return $this->redirectToRoute('app_magical_i_r_w_i_n_index', [], Response::HTTP_SEE_OTHER);
    }
}
