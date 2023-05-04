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

        // return new JsonResponse([
        //     'totalTricks' => count($this->trickRepository->findAll()),
        //     'tricks' => $pagination,
        // ], 200, [], false);

        return $this->render('trick/_tricks.html.twig', [
            'totalTricks' => $this->trickRepository->findAll(),
            'tricks' => $pagination,
        ]);
    }

    #[Route('/comment/paginate', name: 'app_commentaire_paginate', methods: ['GET'])]
    public function commentairePaginate(Request $request, PaginatorInterface $paginator): Response
    {

        $tricksQuery = $this->commentaireRepository->findAllQuery();

        $pagination = $paginator->paginate(
            $tricksQuery,
            $request->query->get('page'),
            10
        );

        return $this->render('trick/_tricks.html.twig', [
            'commentaire' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick->setCreatedAt(new \DateTime());

            $mediasForm = $form->get('medias');

            $trick->setAuteur($this->getUser());
            
            foreach ($mediasForm as $mediaForm) {

                $media = $mediaForm->getData();

                if($media->getType() == 'image') {
                                        
                    $file = $mediaForm->get('image')->getData();

                    if($file instanceof UploadedFile){

                        $fileName = $fileUploader->upload($file);
                        $media->setPath($fileName);
                    }
                }else{

                    $media->setPath($mediaForm->get('video')->getData());
                }
            }

            $this->trickRepository->save($trick, true);

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

            $trick->setCreatedAt(new \DateTime());

            $mediasForm = $form->get('medias');

            $trick->setAuteur($this->getUser());

            foreach ($mediasForm as $mediaForm) {

                $media = $mediaForm->getData();
                if ($media->getType() == 'image') {
                    
                    $file = $mediaForm->get('image')->getData();
                    
                    if ($file instanceof UploadedFile) {
                        $fileName = $fileUploader->upload($file);
                        $media->setPath("images/uploads/" . $fileName);
                    }
                } else {
                    
                    if($mediaForm->get('video')->getData() != null){
                        $media->setPath($mediaForm->get('video')->getData());
                    }
                }
                $this->mediaRepository->save($media, true);
            }

            $this->trickRepository->save($trick, true);

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
    
    #[Route('delete/{slug}', name: 'app_trick_delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick): Response
    {
        $this->denyAccessUnlessGranted('edit', $trick);

        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $this->trickRepository->remove($trick, true);
        }

        return $this->redirectToRoute('app_trick_index', [], Response::HTTP_SEE_OTHER);
    }	
}