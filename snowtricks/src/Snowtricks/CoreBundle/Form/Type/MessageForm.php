<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 23/04/2017
 * Time: 21:39
 */
namespace Snowtricks\CoreBundle\Form\Type;

use Snowtricks\CoreBundle\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextareaType::class, array(
                'label' => 'Votre message : ',
            ))
            ->add('Envoyer', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-success col-xs-12'
                )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
