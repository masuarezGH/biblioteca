<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('apellido', TextType::class, [
                'label' => 'Apellido',
                'attr' => ['class' => 'form-control']
            ])
            ->add('username', TextType::class, [
                'label' => 'Nombre de usuario',
                'attr' => ['class' => 'form-control']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico',
                'attr' => ['class' => 'form-control']
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña',
                'attr' => ['class' => 'form-control']
            ]);
        // rol y estado no se muestran: se setean en el controlador
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
