<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 08/04/2017
 * Time: 09:44
 */
namespace Snowtricks\CoreBundle\Form\Type;


use Snowtricks\CoreBundle\Form\Model\TrickSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickSearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Votre recherche ici : ',
                ),
                'empty_data' => NULL,
                'label' => false,
            ))
            ->add('number', ChoiceType::class, array(
                'choices' => array(
                    '6' => '6',
                    '9' => '9',
                    '18' => '18',
                    '45' => '45',
                    '99' => '99'
                ),
                'preferred_choices' => array('9', 'arr'),
                'label' => 'Par page : ',
                'label_attr' => array(
                    'class' => 'block',
                )
            ))
            ->add('orderedBy', ChoiceType::class, array(
                'choices' => array(
                    'Nom' => 'title',
                    'Date d\'ajout' => 'created_at',
                    'Auteur' => 'created_by',
                    'Groupe' => 'group'
                ),
                'preferred_choices' => array('title', 'arr'),
                'label' => 'Trier par : ',
                'label_attr' => array(
                    'class' => 'block',
                )
            ))
            ->add('order', ChoiceType::class, array(
                'choices' => array(
                    'Descendent' => 'desc',
                    'Ascendent' => 'asc'
                ),
                'preferred_choices' => array('asc', 'arr'),
                'label' => 'Ordre : ',
                'label_attr' => array(
                    'class' => 'block',
                )
            ))
            ->add('firstResult', HiddenType::class, array(
                'data' => "0",
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TrickSearch::class,
        ]);
    }
}
