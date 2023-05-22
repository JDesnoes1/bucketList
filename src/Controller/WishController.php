<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    #[Route('/wish', name: 'wish_list')]
    public function list(WishRepository $wishRepository): Response
    {
        $wishs = $wishRepository->findBy(["isPublished" => true], ["createdDate" => "DESC"], 50, 0);
        return $this->render('wish/list.html.twig', [
            'wishes' => $wishs
        ]);
    }
    #[Route('/wish/{id}', name: 'wish_details',  requirements: ["id" => "\d+"])]
    public function details(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);
        if(!$wish) throw $this->createNotFoundException("Oups ! Wish not found");
        return $this->render('wish/details.html.twig', [
            'wish' => $wish
        ]);
    }

    #[Route('/addWish', name: 'wish_addWish')]
    public function new(Request $request, WishRepository $wishRepository): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);
        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $wish->setCreatedDate(new \DateTime());
            $wish->setIsPublished(true);
            $wishRepository->save($wish, true);

            $this->addFlash("success", message: "Wish successfully added");

            return $this->redirectToRoute('wish_details', ["id" => $wish->getId()]);
        }

        return $this->render('main/addForm.html.twig', [
            'wishForm' => $wishForm->createView()
        ]);
    }
}
