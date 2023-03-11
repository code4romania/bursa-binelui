<?php

namespace App\Form\Registration;

use App\Entity\FrontendUser;
use App\Form\Registration\Company\ContactInfoType;
use App\Form\Registration\Company\InfoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', UserType::class)
            ->add('company', InfoType::class)
            ->add('contact', ContactInfoType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FrontendUser::class,
        ]);
    }
}
