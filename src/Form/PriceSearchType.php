<?php

namespace App\Form;

use App\Entity\PriceSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PriceSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajout des champs pour minPrice et maxPrice
        $builder
            ->add('minPrice', IntegerType::class, [
                'required' => false,
                'label' => 'Prix minimum',
                'attr' => [
                    'placeholder' => 'Entrez le prix minimum',
                    'min' => 0
                ],
            ])
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => 'Prix maximum',
                'attr' => [
                    'placeholder' => 'Entrez le prix maximum',
                    'min' => 0
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Définir l'entité associée au formulaire
        $resolver->setDefaults([
            'data_class' => PriceSearch::class,
        ]);
    }
}
