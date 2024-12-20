<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Program;
use App\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('program', EntityType::class, [
                'class' => Program::class,
                'choice_label' => function (Program $program) {
                    return $program->getName() . ' (' . $program->getCoach()->getFirstName() . ' ' . $program->getCoach()->getLastName() . ')';
                },
                'label' => 'Programme',
            ])
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => function (Customer $customer) {
                    return $customer->getFirstName() . ' ' . $customer->getLastName();
                },
                'label' => 'Client',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}