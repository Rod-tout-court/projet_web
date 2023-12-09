<?php

namespace App\Controller;

use App\Entity\Gif;
use App\Form\SearchType;
use App\Repository\GifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(Request $request, GifRepository $gifRepository): Response
    {
        $form = $this->createForm(SearchType::class);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'GifController',
            'form' => $form,
        ]);
    }
}
