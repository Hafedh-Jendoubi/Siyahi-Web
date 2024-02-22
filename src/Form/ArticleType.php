<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Image',FileType::class, array('data_class' => null,'required' => false))
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Voiture' => 'Voiture',
                    'Immeublier' => 'Immeublier',
                    'Autre' => 'Autre',
                ],
                'expanded' => true, 
                'multiple' => false, // Assurez-vous que seul un bouton peut être sélectionné
            ])
            ->add('NbArticle')
            ->add('Description')
            ->add('Prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
