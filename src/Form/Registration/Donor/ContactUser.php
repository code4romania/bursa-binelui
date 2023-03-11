<?php

namespace App\Form\Registration\Donor;

use App\Form\Registration\BaseContactUserType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactUser extends BaseContactUserType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->add('newsletter', CheckboxType::class, [
            'label' => 'Doresc sa ma abonez la newsletter',
            'required' => false,
        ]);
    }
}
