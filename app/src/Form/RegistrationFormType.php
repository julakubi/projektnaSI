<?php
/**
 * Registration type.
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class RegistrationFormType.
 */
class RegistrationFormType extends AbstractType
{
    /**
     * Builder form.
     *
     * @param FormBuilderInterface $builder Form Builder Interface
     * @param array                $options Array
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                TextType::class,
                [
                    'label' => 'label_username',
                    'required' => true,
                ]
            )
//            ->add('agreeTerms', CheckboxType::class, [
//                'mapped' => false,
//                'constraints' => [
//                    new IsTrue([
//                        'message' => 'You should agree to our terms.',
//                    ]),
//                ],
//            ])
            ->add(
                'password',
                RepeatedType::class,
                [
                    // instead of being set onto the object directly,
                    // this is read and encoded in the controller
                    'type' => PasswordType::class,
                    'required' => true,
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank(),
                        new Length(
                            [
                                'min' => 6,
                                'max' => 255,
                            ]
                        ),
                    ],
                    'first_options' => ['label' => 'label_password'],
                    'second_options' => ['label' => 'label_confirm'],
                ]
            )
            ->add(
                'userdata',
                UserDataType::class,
                [
                    'label' => false,
                    'required' => true,
                ]
            );
    }

    /**
     * Configure options.
     *
     * @param OptionsResolver $resolver Options Resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
