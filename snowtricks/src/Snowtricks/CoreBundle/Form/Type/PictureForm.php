<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 20/04/2017
 * Time: 20:24
 */
namespace Snowtricks\CoreBundle\Form\Type;


use Snowtricks\CoreBundle\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PictureForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array(
                'attr' => array(
                    'class' => 'trick-picture-form',
                    'placeholder' => 'Choissez une image'
                ),
                'label' => false,
                'required' => false
            ))
            ->add('cropData', CropForm::class, array(
                'required' => false
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
            'attr' => array (
                'id' => 'add-picture-form',
            )
        ]);
    }
}

