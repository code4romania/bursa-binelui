<?php

namespace App\Form\Registration;

use App\Form\Registration\Company\ContactInfoType;
use App\Form\Registration\Company\InfoType;
use App\Form\Registration\Donor\ContactUser;
use App\Form\Registration\Donor\UserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', UserType::class)
            ->add('contact', ContactUser::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
