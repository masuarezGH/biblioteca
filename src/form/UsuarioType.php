<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Tu nombre'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El nombre es obligatorio']),
                    new Assert\Length(['min' => 2, 'minMessage' => 'El nombre debe tener al menos {{ limit }} caracteres']),
                ],
            ])
            ->add('apellido', TextType::class, [
                'label' => 'Apellido',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Tu apellido'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El apellido es obligatorio']),
                ],
            ])
            ->add('username', TextType::class, [
                'label' => 'Nombre de usuario',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ej: juanperez'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El nombre de usuario es obligatorio']),
                    new Assert\Length(['min' => 4, 'minMessage' => 'El nombre de usuario debe tener al menos {{ limit }} caracteres']),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico',
                'attr' => ['class' => 'form-control', 'placeholder' => 'ejemplo@correo.com'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El correo electrónico es obligatorio']),
                    new Assert\Email(['message' => 'Debe ingresar un correo electrónico válido']),
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La contraseña es obligatoria']),
                    new Assert\Length([
                        'min' => 6,
                        'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres',
                    ]),
                ],
            ])
        // rol, estado y tipo se setean en el controlador, no en el formulario
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
