<?php

namespace App\Controller;

use App\Entity\Gif;
use App\Form\GifType;
use App\Repository\GifRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/gif')]
class GifController extends AbstractController
{
    #[Route('/', name: 'app_gif_index', methods: ['GET'])]
    public function index(GifRepository $gifRepository): Response
    {
        $isUserLoggedIn = $this->isGranted('IS_AUTHENTICATED_FULLY');

    if ($isUserLoggedIn) {
        // Utilisateur connecté, récupérer les GIFs de l'utilisateur
        $user = $this->getUser();
        $gifs = $gifRepository->findBy(['author' => $user]);
    } else {
        // Utilisateur non connecté, récupérer tous les GIFs publics
        $gifs = $gifRepository->findBy(['visible' => true]);
    }

        return $this->render('gif/index.html.twig', [
            'gifs' => $gifs,
        ]);
    }
    

    #[Route('/new', name: 'app_gif_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Créer une nouvelle instance de Gif avec l'utilisateur comme auteur
        $gif = new Gif($user);
        $gif->setAuthor($user);

        $form = $this->createForm(GifType::class, $gif, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer le fichier GIF
            $gifFile = $form->get('gif')->getData();
            if ($gifFile) {
                $originalFilename = pathinfo($gifFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$gifFile->guessExtension();

                try {
                    $gifFile->move(
                        $this->getParameter('gif_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'erreur de téléchargement du fichier
                }

                $gif->setGifFilename($newFilename);
            }

            // Persister le Gif
            $entityManager->persist($gif);
            $entityManager->flush();

            return $this->redirectToRoute('app_gif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gif/new.html.twig', [
            'gif' => $gif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gif_show', methods: ['GET'])]
    public function show(Gif $gif): Response
    {
        return $this->render('gif/show.html.twig', [
            'gif' => $gif,
        ]);
    }

   

    #[Route('/{id}/edit', name: 'app_gif_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gif $gif, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si l'utilisateur actuel est l'auteur du GIF
        $currentUser = $this->getUser();
        if ($currentUser !== $gif->getAuthor()) {
            // Rediriger ou afficher un message d'erreur, car l'utilisateur n'est pas autorisé à modifier ce GIF
            // Par exemple, rediriger vers une page d'accès refusé
            return $this->redirectToRoute('access_denied'); // Remplacez 'access_denied' par le nom de votre route d'accès refusé
        }

        $form = $this->createForm(GifType::class, $gif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_gif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gif/edit.html.twig', [
            'gif' => $gif,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_gif_delete', methods: ['POST'])]
    public function delete(Request $request, Gif $gif, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si l'utilisateur actuel est l'auteur du GIF
        $currentUser = $this->getUser();
        if ($currentUser !== $gif->getAuthor()) {
            // Rediriger ou afficher un message d'erreur, car l'utilisateur n'est pas autorisé à supprimer ce GIF
            // Par exemple, rediriger vers une page d'accès refusé
            return $this->redirectToRoute('access_denied'); // Remplacez 'access_denied' par le nom de votre route d'accès refusé
        }
    
        if ($this->isCsrfTokenValid('delete'.$gif->getId(), $request->request->get('_token'))) {
            $entityManager->remove($gif);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_gif_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
