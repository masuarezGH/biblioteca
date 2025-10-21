<?php
namespace App\Form;

use App\Entity\Libro;
use App\Enum\EstadoLibro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LibroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Título',
            ])
            ->add('autor', TextType::class, [
                'label' => 'Autor',
            ])
            ->add('genero', TextType::class, [
                'label' => 'Género',
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
            ])
            ->add('imagen', FileType::class, [
                'label' => 'Imagen (portada)',
                'mapped' => false,   // no se guarda directo en la entidad
                'required' => false, // opcional
            ])
            ->add('estado', ChoiceType::class, [
                'label' => 'Estado',
                'choices' => [
                    'Disponible' => EstadoLibro::DISPONIBLE,
                    'Prestado'   => EstadoLibro::PRESTADO,
                ],
                'expanded' => false,
                'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Libro::class,
        ]);
    }
}
