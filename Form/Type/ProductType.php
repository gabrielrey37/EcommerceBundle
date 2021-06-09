<?php

namespace MauticPlugin\EcommerceBundle\Form\Type;

use Mautic\CoreBundle\Security\Permissions\CorePermissions;
use MauticPlugin\EcommerceBundle\Entity\Product;
use Mautic\CategoryBundle\Form\Type\CategoryListType;
use Mautic\CoreBundle\Form\EventListener\CleanFormSubscriber;
use Mautic\CoreBundle\Form\EventListener\FormExitSubscriber;
use Mautic\CoreBundle\Form\Type\FormButtonsType;
use Mautic\CoreBundle\Form\Type\YesNoButtonGroupType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    private $security;

    public function __construct(CorePermissions $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->addEventSubscriber(new CleanFormSubscriber(['shortDescription' => 'html', 'longDescription' => 'html']));
        $builder->addEventSubscriber(new FormExitSubscriber('product', $options));

        $builder->add(
            'name',
            TextType::class,
            [
                'label'      => 'mautic.core.name',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => ['class' => 'form-control'],
            ]
        );
        
        $builder->add(
            'productId',
            TextType::class,
            [
                'label'      => 'mautic.ecommerce.product.productId',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'   => 'form-control',
                ],
                'required' => true,
            ]
        );

        $builder->add(
            'productAttributeId',
            TextType::class,
            [
                'label'      => 'mautic.ecommerce.product.productAttributeId',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'   => 'form-control',
                ],
                'required' => false,
            ]
        );

        $builder->add(
            'taxPercent',
            TextType::class,
            [
                'label'      => 'mautic.ecommerce.product.taxPercent',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'   => 'form-control',
                ],
                'required' => false,
            ]
        );

        $builder->add('language', LocaleType::class, [
            'label'      => 'mautic.core.language',
            'label_attr' => ['class' => 'control-label'],
            'attr'       => [
                'class'   => 'form-control',
            ],
            'required' => false,
        ]);


        $builder->add(
            'url',
            TextType::class,
            [
                'label'      => 'mautic.ecommerce.product.url',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'   => 'form-control',
                ],
                'required' => false,
            ]
        );
        
        $builder->add(
            'reference',
            TextType::class,
            [
                'label'      => 'mautic.ecommerce.product.reference',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'   => 'form-control',
                ],
                'required' => false,
            ]
        );

        
        $builder->add(
            'imageUrl',
            TextType::class,
            [
                'label'      => 'mautic.ecommerce.product.imageUrl',
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
                'label'      => 'mautic.ecommerce.product.shopId',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'   => 'form-control',
                ],
                'required' => false,
            ]
        );


        $builder->add(
            'price',
            TextType::class,
            [
                'label'      => 'mautic.ecommerce.product.price',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'   => 'form-control',
                ],
                'required' => false,
            ]
        );

        
        $builder->add(
            'shortDescription',
            TextareaType::class,
            [
                'label'      => 'mautic.ecommerce.product.shortDescription',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => ['class' => 'form-control editor'],
                'required'   => false,
            ]
        );
        
        $builder->add(
            'longDescription',
            TextareaType::class,
            [
                'label'      => 'mautic.ecommerce.product.longDescription',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'                => 'form-control editor editor-advanced',
                    'rows'                 => '15',
                ],
                'required' => false,
            ]
        );
        
        //*******************************

        $builder->add(
            'category',
            CategoryListType::class,
            [
                'bundle' => 'plugin:ecommerce',
            ]
        );

        $builder->add('isPublished', YesNoButtonGroupType::class);

        $builder->add('publishUp', DateTimeType::class, [
            'widget'     => 'single_text',
            'label'      => 'mautic.core.form.publishup',
            'label_attr' => ['class' => 'control-label'],
            'attr'       => [
                'class'       => 'form-control',
                'data-toggle' => 'datetime',
            ],
            'format'   => 'yyyy-MM-dd HH:mm',
            'required' => false,
        ]);

        $builder->add(
            'publishDown',
            DateTimeType::class,
            [
                'widget'     => 'single_text',
                'label'      => 'mautic.core.form.publishdown',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'       => 'form-control',
                    'data-toggle' => 'datetime',
                ],
                'format'   => 'yyyy-MM-dd HH:mm',
                'required' => false,
            ]
        );



        $builder->add('buttons', FormButtonsType::class, []);

        if (!empty($options['action'])) {
            $builder->setAction($options['action']);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Product::class]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'product';
    }
}
