<?php

namespace App\Form;

use App\Entity\CategorySearch;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategorySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,          // Entité liée à ce champ
                'choice_label' => 'titre',           // Affichage du label (titre de la catégorie)
                'placeholder' => 'Choisir une catégorie', // Texte de placeholder
                'required' => false,                 // Non obligatoire
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorySearch::class,  // Indiquer que ce formulaire est lié à l'entité CategorySearch
        ]);
    }
}
