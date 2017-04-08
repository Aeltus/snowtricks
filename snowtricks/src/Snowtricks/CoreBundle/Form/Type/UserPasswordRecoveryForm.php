<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 08/04/2017
 * Time: 22:35
 */
namespace Snowtricks\CoreBundle\Form\Type;


use Snowtricks\CoreBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPasswordRecoveryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mail', EmailType::class, array(
                'label' => 'Votre email : '
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['Recovery']
        ]);
    }
}
