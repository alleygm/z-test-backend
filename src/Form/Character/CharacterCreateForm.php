<?php

namespace App\Form\Character;

use App\Entity\Characters\CharacterClass;
use App\Entity\Characters\Characters;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CharacterCreateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Имя",
                'row_attr' => [
                    'class' => ""
                ],
                'attr' => [
                    'placeholder' => "Имя персонажа",
                    'class' => ""
                ],
            ])
            ->add('class', EntityType::class, [
                'class' => CharacterClass::class,
                'label' => "Выберите класс персонажа",
                'choice_label' => 'name',
            ])
            ->add('submit', SubmitType::class, [
                'label' => "создать",
                'row_attr' => [
                    'class' => 'default-btn'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Characters::class,
            'attr' => ["class" => 'flex flex-col gap-3'],
        ]);
    }
}
