<?php

namespace App\Form;

use App\Entity\AltContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('middleName')
            ->add('lastName')
            ->add('title')
            ->add('birthday')
            ->add('created')
            ->add('changed')
            ->add('locales')
            ->add('changer')
            ->add('creator')
            ->add('note')
            ->add('notes')
            ->add('emails')
            ->add('phones')
            ->add('faxes')
            ->add('socialMediaProfiles')
            ->add('formOfAddress')
            ->add('salutation')
            ->add('tags')
            ->add('account')
            ->add('addresses')
            ->add('accountContacts')
            ->add('newsletter')
            ->add('gender')
            ->add('mainEmail')
            ->add('mainPhone')
            ->add('mainFax')
            ->add('mainUrl')
            ->add('contactAddresses')
            ->add('medias')
            ->add('categories')
            ->add('urls')
            ->add('bankAccounts')
            ->add('avatar')
            ->add('apiBasePath')
            ->add('apiPath')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => '',
        ]);
    }
}
