<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 29/04/2017
 * Time: 11:23
 */
namespace Snowtricks\CoreBundle\Form\Type;

use Snowtricks\CoreBundle\Form\Entity\CropData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CropForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cropSizeHeight', HiddenType::class)
            ->add('cropSizeWidth', HiddenType::class)
            ->add('cropPositionTop', HiddenType::class)
            ->add('cropPositionLeft', HiddenType::class)
            ->add('cropHolderHeight', HiddenType::class)
            ->add('cropHolderWidth', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CropData::class,
            'label' => false
        ]);
    }
}

