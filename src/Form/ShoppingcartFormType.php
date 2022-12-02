<?php

namespace App\Form;

use App\Entity\ShoppingcartPizza;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShoppingcartFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', ChoiceType::class, [
                'choices' => [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                ],
            ])
            ->add('size', ChoiceType::class, [
                'choices' => [
                    '25cm' => '25cm',
                    '35cm' => '35cm',
                ],
            ])
            ->add('calzone', ChoiceType::class, [
                'choices' => [
                    'No' => '0',
                    'Yes' => '1',
                ],
            ])
            ->add('add', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShoppingcartPizza::class,
        ]);
    }
}
