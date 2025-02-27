<?php

namespace App\Form\Type;

use App\Entity\Ducks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DuckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duckname')
            ->add('email', EmailType::class)
            ->add('firstname')
            ->add('lastname')
            ->add('profilePicture')
            ->add('password', PasswordType::class);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'=>Ducks::class,
        ]);
    }
}