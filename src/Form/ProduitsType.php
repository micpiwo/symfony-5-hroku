<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Distributeur;
use App\Entity\Produits;
use App\Repository\CategoriesRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitsType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomProduit', TextType::class)
            ->add('descriptionProduit', TextareaType::class)
            ->add('prixProduit', NumberType::class)
            ->add('imageProduit', FileType::class,[
                'label' => 'Image',
                'required' => false,
                'data_class' => null,
                'empty_data' => 'aucune image'
            ])
            ->add('stockProduit', ChoiceType::class,[
                'choices' => [
                    'OUI' => true,
                    'NON' => false
                ]
            ])
            ->add('created_at', DateType::class)
            ->add('categorie_id', EntityType::class,[
                'class' => Categories::class,
                'choice_label' => function(Categories $categories){
                return $categories->getNomCategorie();
                }
            ])
            ->add('references', ReferenceType::class,[
                'required' => false
            ])
            ->add('distributeurs', EntityType::class,[
                'label' => 'Choix des distributeurs',
                'class' => Distributeur::class,
                'multiple' => true,
                'required' => false,
                'choice_label' => function(Distributeur $distributeur){
                return $distributeur->getNomDistributeur();
                }
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
