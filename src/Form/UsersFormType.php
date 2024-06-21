<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', options:[
                'label' => 'Nom'
            ])
            ->add('firstname', options:[
                'label' => 'Prénom'
            ])
            ->add('email')
            ->add('address')
            ->add('zipcode')
            ->add('city')
            // ->add('phoneNumber', options:[
            //     'label' => 'Téléphone'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}