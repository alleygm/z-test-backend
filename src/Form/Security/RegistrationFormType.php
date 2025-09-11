<?php

namespace App\Form\Security;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'email'
            ])
            ->add('plainPassword', PasswordType::class, [
                'label'       => 'пароль',
                'mapped'      => false,
                'attr'        => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Пароль не может быть пустым',
                    ]),
                    new Length([
                        'min'        => 6,
                        'minMessage' => 'пароль должен быть не меньше {{ limit }} символов',
                        'max'        => 4096,
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label'    => 'зарегистрироваться',
                "row_attr" => [
                    'class' => "flex flex-col justify-center"
                ],
                'attr'     => [
                    'class' => 'default-btn',
                    'type'  => 'submit'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => ["class" => 'flex flex-col gap-3'],
            'data_class' => User::class,
        ]);
    }
}
