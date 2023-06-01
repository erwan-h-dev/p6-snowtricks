<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Service\FileUploader;
use App\Repository\MediaRepository;
use App\Repository\TrickRepository;
use App\Repository\CommentaireRepository;
use App\Service\TrickManager;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/trick')]
class TrickController extends AbstractController
{
    // construct
    public function __construct(
        private TrickManager $trickManager,
        private TrickRepository $trickRepository,
        private MediaRepository $mediaRepository,
        private CommentaireRepository $commentaireRepository
    ){ }

    #[Route('/liste', name: 'app_trick_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('trick/index.html.twig', [
            'tricks' => $this->trickRepository->findAll(),
        ]);
    }

    #[Route('/paginate', name: 'app_trick_paginate', methods: ['GET'])]
    public function paginate(Request $request, PaginatorInterface $paginator): Response
    {
        $tricksQuery = $this->trickRepository->findAllQuery();

        $pagination = $paginator->paginate(
            $tricksQuery,
            $request->query->get('page'),
            12
        );

        return $this->render('trick/_tricks.html.twig', [
            'totalTricks' => $this->trickRepository->findAll(),
            'tricks' => $pagination,
        ]);
    }

    #[Route('/commentaire/paginate/{id}', name: 'app_commentaire_paginate', methods: ['GET'])]
    public function commentairePaginate(Request $request, Trick $trick, PaginatorInterface $paginator): Response
    {
        $commentairesQuery = $this->commentaireRepository->findTrickCommentairesQuery($trick);

        $pagination = $paginator->paginate(
            $commentairesQuery,
            $request->query->get('page'),
            10
        );

        return $this->render('trick/_commentaires.html.twig', [
            'commentaires' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->trickManager->createTrick($trick, $form);
            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{slug}', name: 'app_trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trick $trick, FileUploader $fileUploader): Response
    {
        $this->denyAccessUnlessGranted('edit', $trick);

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->trickManager->createTrick($trick, $form);

            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{slug}', name: 'app_trick_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Trick $trick): Response
    {
        $commentaire = new Commentaire();
        
        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $commentaire->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setAuteur($this->getUser())
            ;

            $this->commentaireRepository->save($commentaire, true);

            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }
    
    #[Route('/delete/{slug}', name: 'app_trick_delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick): Response
    {
        $this->denyAccessUnlessGranted('edit', $trick);

        $this->trickRepository->remove($trick, true);

        return $this->redirectToRoute('app_trick_index', [], Response::HTTP_SEE_OTHER);
    }
}