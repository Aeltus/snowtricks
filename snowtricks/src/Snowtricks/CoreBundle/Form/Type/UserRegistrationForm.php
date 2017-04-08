<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 05/04/2017
 * Time: 22:35
 */
namespace Snowtricks\CoreBundle\Form\Type;

use Snowtricks\CoreBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Votre nom : ',
            ))
            ->add('surname', TextType::class, array(
                'label' => 'Votre prénom : '
            ))
            ->add('mail', EmailType::class, array(
                'label' => 'Email : '
            ))
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class
            ])
            ->add('file', FileType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Choisissez une image'
                    )
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['Default', 'Registration']
        ]);
    }
}
