<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Eckinox\TinymceBundle\Form\Type\TinymceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TinymceType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'class' => 'tinymce',
                    'height' => '200',
                    'menubar' => null,
                    'toolbar' => 'bold italic | alignleft aligncenter alignright alignjustify',
                    'add_form_submit_trigger' => true,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
