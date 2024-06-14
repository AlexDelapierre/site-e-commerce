<?php

namespace App\Form;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('categoryOrder')
            ->add('slug')
            ->add('parent', EntityType::class, [
                // looks for choices from this entity
                'class' => Categories::class,
            
                // uses the Category.name property as the visible option string
                'choice_label' => 'name',
                'query_builder' => function(CategoriesRepository $CategoriesRepository) 
                {
                    return  $CategoriesRepository->createQueryBuilder('category')
                        ->where('category.parent IS NULL')
                        ->orderBy('category.name', 'ASC'); 
                }
                
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}