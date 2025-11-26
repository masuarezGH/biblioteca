<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nombre de usuario',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El nombre de usuario es obligatorio']),
                    new Assert\Length([
                        'min' => 4,
                        'minMessage' => 'Debe tener al menos {{ limit }} caracteres',
                        'max' => 15,
                        'maxMessage' => 'No puede tener más de {{ limit }} caracteres',
                        ]),
                ],
            ])
            ->add('nombre', TextType::class, [
                'label' => 'Nombre',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El nombre es obligatorio']),
                    new Assert\Length([
                        'min' => 4,
                        'minMessage' => 'Debe tener al menos {{ limit }} caracteres',
                        'max' => 15,
                        'maxMessage' => 'No puede tener más de {{ limit }} caracteres',
                        ]),
                ],
            ])
            ->add('apellido', TextType::class, [
                'label' => 'Apellido',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El apellido es obligatorio']),
                    new Assert\Length([
                        'min' => 4,
                        'minMessage' => 'Debe tener al menos {{ limit }} caracteres',
                        'max' => 15,
                        'maxMessage' => 'No puede tener más de {{ limit }} caracteres',
                        ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico',
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => true, 
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
            ])
                ->add('password', PasswordType::class, [
                'label' => 'Nueva contraseña (opcional)',
                'mapped' => false,   // <- clave: no pisa la entidad
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\Length([
                        'min' => 6,
                        'minMessage' => 'Debe tener al menos {{ limit }} caracteres',
                    ]),
                ],
            ]);
    }
        

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
