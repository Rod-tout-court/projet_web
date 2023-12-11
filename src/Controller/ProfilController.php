<?php

namespace App\Controller;

use App\Form\ProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil_show')]
    public function showProfil()
    {
        $user = $this->getUser();

        return $this->render('profil/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profil/edit', name: 'app_profil_edit')]
public function editProfil(Request $request, SluggerInterface $slugger, PersistenceManagerRegistry $doctrine)
{
    $user = $this->getUser();
    $form = $this->createForm(ProfilType::class, $user);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $photoProfilFile = $form->get('photoProfil')->getData();
        if ($photoProfilFile) {
            $originalFilename = pathinfo($photoProfilFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoProfilFile->guessExtension();

            try {
                $photoProfilFile->move(
                    $this->getParameter('photoProfil_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                //gérer
            }
            $user->setPhotoProfilFilename($newFilename);
        }

        
        $entityManager = $doctrine->getManager(); // Fixed this line

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_profil_show');
    }

    return $this->render('profil/edit.html.twig', [
        'user' => $user,
        'form' => $form->createView(),
    ]);
}
}
