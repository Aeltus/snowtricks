<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 25/04/2017
 * Time: 20:59
 */
namespace Snowtricks\CoreBundle\Form\Type;


use Snowtricks\CoreBundle\Form\Model\MessageSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageSearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstResult', HiddenType::class)
            ->add('number', HiddenType::class)
            ->add('ok', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MessageSearch::class,
        ]);
    }
}

