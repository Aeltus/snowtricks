<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 22/04/2017
 * Time: 09:08
 */
namespace Snowtricks\CoreBundle\Form\Type;

use Snowtricks\CoreBundle\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', TextareaType::class, array(
                'attr' => array(
                    'class' => 'trick-video-form',
                ),
                'label' => 'Ajoutez une video à la figure : ',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
            'attr' => array (
                'id' => 'add-video-form',
            )
        ]);
    }
}


