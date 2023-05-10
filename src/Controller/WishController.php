<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    #[Route('/wish', name: 'wish_list')]
    public function list(): Response
    {
        return $this->render('wish/list.html.twig', [
            'controller_name' => 'WishController',
        ]);
    }
    #[Route('/wish/{id}', name: 'wish_details',  requirements: ["id" => "\d+"])]
    public function details(int $id): Response
    {
        dump($id);
        return $this->render('wish/details.html.twig', [
            "id" => $id
        ]);
    }
}
