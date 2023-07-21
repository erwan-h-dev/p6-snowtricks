<?php
namespace App\Service;

use App\Entity\Trick;
use App\Service\FileUploader;
use App\Repository\TrickRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TrickManager
{
    public function __construct(
        private Security $security,
        private FileUploader $fileUploader,
        private TrickRepository $trickRepository
    ) { }
    
    public function createTrick(Trick $trick,FormInterface $form)
    {
        
        $trick->setAuteur($this->security->getUser());

        $mediasForm = $form->get('medias');

        foreach ($mediasForm as $mediaForm) {

            $media = $mediaForm->getData();

            if ($media->getType() == 'image') {

                $file = $mediaForm->get('image')->getData();

                if ($file instanceof UploadedFile) {

                    $fileName = $this->fileUploader->upload($file);
                    $media->setPath('images/uploads/' . $fileName);
                }
            } else {

                $media->setPath($mediaForm->get('video')->getData());
            }
        }

        $this->trickRepository->save($trick, true);
    }
}
