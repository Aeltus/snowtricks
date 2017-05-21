<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 06/05/2017
 * Time: 18:17
 */
namespace Snowtricks\CoreBundle\Form\Type;

use Snowtricks\CoreBundle\Form\Model\UserSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('searchName', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Le nom recherché ici :',
                ),
                'empty_data' => NULL,
                'label' => false,
            ))
            ->add('searchSurname', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Le prenom recherché ici :',
                ),
                'empty_data' => NULL,
                'label' => false,
            ))
            ->add('firstResult', HiddenType::class)
            ->add('Rechercher', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-success top10 bottom10 col-xs-12',
                    'formnovalidate' => '',
                ),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSearch::class,
        ]);
    }
}

