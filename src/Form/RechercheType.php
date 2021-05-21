<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Produits;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('prixProduit', NumberType::class,[
                'required' => false
            ])

            ->add('categorie_id', EntityType::class,[
                'class' => Categories::class,
                'choice_label'=>'nomCategorie',
                'required' => false

            ])
            ->add('recherche', SubmitType::class,[
                'label'=> 'Rechercher'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,

        ]);
    }

}
