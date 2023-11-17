<?php

namespace App\Form;

use App\Entity\Duck;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifyDuckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('profilePicture')
//              StringType::class,[
//        'label' => 'Profile Picture',
//        'required' => false]
            ->add('firstname')
            ->add('lastname')
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Duck::class,
        ]);
    }
}
