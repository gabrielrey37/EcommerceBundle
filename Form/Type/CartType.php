<?php

namespace MauticPlugin\EcommerceBundle\Form\Type;

use Mautic\CoreBundle\Security\Permissions\CorePermissions;
use MauticPlugin\EcommerceBundle\Entity\Cart;
use Mautic\CoreBundle\Form\Type\FormButtonsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    private $security;

    public function __construct(CorePermissions $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'cartId',
            TextType::class,
            [
                'label'      => 'mautic.ecommerce.cart.cartId',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => ['class' => 'form-control'],
            ]
        );


        $builder->add(
            'carrierId',
            TextType::class,
            [
                'label'      => 'mautic.ecommerce.cart.carrierId',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'   => 'form-control',
                ],
                'required' => false,
            ]
        );

        $builder->add(
            'shopId',
            TextType::class,
            [
                'label'      => 'mautic.ecommerce.cart.shopId',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'   => 'form-control',
                ],
                'required' => false,
            ]
        );

        $builder->add(
            'cartLines',
            CollectionType::class,
            [
                'entry_type' => CartLineType::class,
                'label'      => false,
                'attr'       => [
                    'class'   => 'form-control',
                ],
                'mapped'         => true,
                'allow_add'      => true,
                'allow_delete'   => true,
            ]
        );


        $builder->add('buttons', FormButtonsType::class, []);

        if (!empty($options['action'])) {
            $builder->setAction($options['action']);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Cart::class]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'cart';
    }
}
