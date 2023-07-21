<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(TrickRepository $trickRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }

    public static function typeMedia(): array
    {
        return [
            'image' => 'image',
            'video' => 'video',
        ];
    }
}
