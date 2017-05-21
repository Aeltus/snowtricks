<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 19/04/2017
 * Time: 19:18
 */
namespace Snowtricks\CoreBundle\Form\Type;

use Snowtricks\CoreBundle\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Le titre de la figure ici : ',
                ),
                'label' => 'Titre : ',
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description : ',
            ))
            ->add('group', EntityType::class, array(
                'class' => 'SnowtricksCoreBundle:Group',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' =>false,
                'label' => 'Groupe : '
            ))
            ->add('uploadPictures', CollectionType::class, array(
                'entry_type' => PictureForm::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'required' => false
            ))
            ->add('videos', CollectionType::class, array(
                'entry_type' => VideoForm::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'required' => false
            ))
            ->add('Valider', SubmitType::class, array(
        'attr' => array(
            'class' => 'btn btn-success top10 bottom10 col-xs-12'
        )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
