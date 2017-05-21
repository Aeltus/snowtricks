<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 07/05/2017
 * Time: 10:43
 */
namespace Snowtricks\CoreBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;


class UserRegistrationAdminForm extends AbstractType

{

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        $builder->remove('plainPassword')
                ->add('roles', ChoiceType::class, array(
                        'attr'  =>  array('class' => 'form-control',
                            'style' => 'margin:5px 0;'),
                        'choices' =>
                            array
                            (
                                'Administrateur' => 'ROLE_ADMIN',
                                'Modérateur' => 'ROLE_MODERATOR',
                                'Utilisateur' => 'ROLE_USER'
                            ) ,
                        'multiple' => true,
                        'required' => true,
                    )
                );;

    }


    public function getParent()

    {

        return UserRegistrationForm::class;

    }

}
