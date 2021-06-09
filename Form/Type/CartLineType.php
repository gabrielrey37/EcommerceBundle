<?php

namespace MauticPlugin\EcommerceBundle\Form\Type;

use Mautic\CoreBundle\Security\Permissions\CorePermissions;
use MauticPlugin\EcommerceBundle\Entity\CartLine;
use Mautic\CoreBundle\Form\Type\FormButtonsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartLineType extends AbstractType
{
    private $security;

    public function __construct(CorePermissions $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add(
            'productId',
            TextType::class,
            [
                'label'      => 'mautic.ecommerce.productId',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => ['class' => 'form-control'],
            ]
        );

        $builder->add(
            'quantity',
            TextType::class,
            [
                'label'      => 'mautic.ecommerce.quantity',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => ['class' => 'form-control'],
            ]
        );

        $builder->add('buttons', FormButtonsType::class, []);

        if (!empty($options['action'])) {
            $builder->setAction($options['action']);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => CartLine::class]);
    }

    public function getBlockPrefix()
    {
        return 'cartline';
    }
}
