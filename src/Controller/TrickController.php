<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Service\FileUploader;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/trick')]
class TrickController extends AbstractController
{
    #[Route('/liste', name: 'app_trick_index', methods: ['GET'])]
    public function index(TrickRepository $trickRepository): Response
    {
        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrickRepository $trickRepository, FileUploader $fileUploader): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick->setCreatedAt(new \DateTime());

            $mediasForm = $form->get('medias');
            
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

            $trickRepository->save($trick, true);

            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{slug}', name: 'app_trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trick $trick, TrickRepository $trickRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mediasForm = $form->get('medias');
            
            foreach ($mediasForm as $mediaForm) {

                $media = $mediaForm->getData();

                if($media->getType() == 'image') {
                                        
                    $file = $mediaForm->get('image')->getData();

                    if($file instanceof UploadedFile){

                        $fileName = $fileUploader->upload($file);
                        
                        $media->getPath($fileName);

                    }
                }else{
                    if($mediaForm->get('video')->getData() != null){
                        $media->setPath($mediaForm->get('video')->getData());
                    }
                }
            }

            $trickRepository->save($trick, true);

            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

         return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{slug}', name: 'app_trick_show', methods: ['GET'])]
    public function show(Trick $trick): Response
    {
        $form = "";

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    
    #[Route('/{slug}', name: 'app_trick_delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $trickRepository->remove($trick, true);
        }

        return $this->redirectToRoute('app_trick_index', [], Response::HTTP_SEE_OTHER);
    }	
}