<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom') // Ajout du champ pour le nom de l'article
            ->add('prix') // Ajout du champ pour le prix de l'article
            ->add('category', EntityType::class, [
                'class' => Category::class, // Entité Category à utiliser
                'choice_label' => 'titre',  // Champ à afficher dans la liste déroulante
                'label' => 'Catégorie',     // Libellé du champ
                'placeholder' => 'Sélectionnez une catégorie',  // Texte par défaut pour le champ
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class, // Entité Article pour ce formulaire
        ]);
    }
}
