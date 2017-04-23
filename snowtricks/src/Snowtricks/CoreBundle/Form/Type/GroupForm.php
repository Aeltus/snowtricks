<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 15/04/2017
 * Time: 10:50
 */

namespace Snowtricks\CoreBundle\Form\Type;

use Snowtricks\CoreBundle\Entity\Group;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Le nom du nouveau goupe ici : ',
                ),
                'empty_data' => NULL,
                'label' => 'Ajouter un groupe : ',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
