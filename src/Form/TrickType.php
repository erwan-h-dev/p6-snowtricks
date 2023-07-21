<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\Trick;
use App\Form\MediaType;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Eckinox\TinymceBundle\Form\Type\TinymceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'libelle',
                'required' => true,
                'attr' => [
                    'class' => 'select2',
                ]
            ])
            ->add('content', TinymceType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'tinymce',
                    'height' => '600',
                    'menubar' => null,
                    'toolbar' => 'undo redo | forecolor backcolor | blocks | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
                    'add_form_submit_trigger' => true,
                ],
            ])
            ->add('medias', CollectionType::class, [
                'entry_type' => MediaType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => [
                    'label' => false,
                ],
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
