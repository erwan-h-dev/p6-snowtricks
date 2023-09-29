<?php

namespace App\Form;

use App\Entity\Media;
use App\Service\ListService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $listService = new ListService();

        $builder
            ->add('type', ChoiceType::class, [
                'choices' => $listService->typeMediaList(),
                'attr' => [
                    'class' => 'type-select',
                ]
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'mapped' => false,
                'label' => false,
                'attr' => [
                    'class' => 'image-field',
                ]
            ])
            ->add('video', TextType::class, [
                'required' => false,
                'mapped' => false,
                'label' => false,
                'attr' => [
                    'class' => 'video-field',
                    'style' => 'display: none;'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
