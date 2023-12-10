<?php

namespace App\Controller;

use App\Repository\GifRepository;
use App\Form\GifType;
use App\Form\UserType;
use App\Entity\Gif;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_MOD', statusCode:403)]
#[Route('/admin')]
class AdminController extends AbstractController
{
    public function unauthorize(){
        return new Response("Unauthorized", 403);
    }

    #[Route('/', name: 'app_admin')]
    public function index(UserRepository $userRepository, GifRepository $gifRepository): Response
    {

        $users = $userRepository->findAll();
        $gifs = $gifRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'gifs' => $gifs,
        ]);

    }

    #[Route('/gif', name:'app_admin_gif')]
    public function admin_gif(GifRepository $gifRepository) :Response {
        $gifs = $gifRepository->findAll();
        return $this->render('gif/index.html.twig', [
            'gifs' => $gifs,
        ]);
    }

    #[Route('/gif/{id}/delete', name: 'app_admin_gif_delete', methods: ['GET'])]
    public function delete(Request $request, Gif $gif, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si l'utilisateur actuel est l'auteur du GIF
        $currentUser = $this->getUser();
        if ($this->isGranted('ROLE_ADMIN')) {
            // Rediriger ou afficher un message d'erreur, car l'utilisateur n'est pas autorisé à supprimer ce GIF
            // Par exemple, rediriger vers une page d'accès refusé
            return $this->redirectToRoute('access_denied'); // Remplacez 'access_denied' par le nom de votre route d'accès refusé
        }
    
        $entityManager->remove($gif);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/gif/{id}/visible', name: 'app_admin_gif_visible', methods: ['GET'])]
    public function visibility(Request $request, Gif $gif, EntityManagerInterface $entityManager): Response
    {
        if ( $this->isGranted('ROLE_ADMIN') ) {
            // Rediriger ou afficher un message d'erreur, car l'utilisateur n'est pas autorisé à supprimer ce GIF
            // Par exemple, rediriger vers une page d'accès refusé
            return $this->redirectToRoute('access_denied'); // Remplacez 'access_denied' par le nom de votre route d'accès refusé
        }
        $gif->setVisible(!$gif->isVisible());
        $entityManager->persist($gif);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/user/{id}/blocked', name: 'app_admin_user_blocked', methods: ['GET'])]
    public function userBlocked(Request $request, User $user, EntityManagerInterface $entityManager){
            // Vérifier si l'utilisateur actuel est l'auteur du GIF
            if(in_array('ROLE_BLOCKED', $user->getRoles())){
                $user->setRoles(['ROLE_USER']);
            } else {
                $user->setRoles(['ROLE_BLOCKED']);
            }
            $entityManager->persist($user);
            $entityManager->flush();
        
            return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
}

}
