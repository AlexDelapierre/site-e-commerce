<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Products;
use App\Repository\CategoriesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Positive;

class ProductsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options:[
                'label' => 'Nom'
            ])
            ->add('description')
            ->add('price', MoneyType::class, options:[
                'label' => 'prix',
                'divisor' => 100,
                'constraints' => [
                    new Positive(
                        message: 'Le prix ne peut être négatif'
                    )
                ] 
            ])
            ->add('stock', options:[
                'label' => 'Unités en stock'
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
                'label' => 'Catégorie',
                'group_by' => 'parent.name',
                'query_builder' => function(CategoriesRepository $CategoriesRepository) 
                {
                    return  $CategoriesRepository->createQueryBuilder('category')
                        ->where('category.parent IS NOT NULL')
                        ->orderBy('category.name', 'ASC'); 
                }
            ])
            ->add('image', FileType::class, [
                'label' => false,
                //La contrainte multiple permet de dire que c'est un tableau d'image
                'multiple' => true,
                //Symfony ne va pas vérifier si on a l'équivalent dans l'entité avec mapped
                'mapped' => false, 
                'required' => false,
                'constraints' => [
                    // En cas d'image multiple, on doit encapsuler new Image() dans new All() pour éviter une erreur
                    new All(
                        new Image([
                            'maxWidth' => 1280,
                            'maxWidthMessage' => 'L\'image doit faire {{ max_width }} pixels de large au maximum'
                        ])
                    )
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}