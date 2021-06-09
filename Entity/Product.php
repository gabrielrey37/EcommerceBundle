<?php

namespace MauticPlugin\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mautic\ApiBundle\Serializer\Driver\ApiMetadataDriver;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use Mautic\CoreBundle\Entity\FormEntity;
use Mautic\LeadBundle\Entity\CustomFieldEntityTrait as CustomFieldEntityTrait;

class Product extends FormEntity {
    use CustomFieldEntityTrait;

    private $id;

    private $name;

    private $productId;

    private $productAttributeId;

    private $shopId;

    private $imageUrl;

    private $url;

    private $category;

    private $shortDescription;

    private $price;

    private $reference;

    private $longDescription;

    private $type;

    private $taxPercent;

    private $language = 'en';

    public static function loadMetadata(ORM\ClassMetadata $metadata): void
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder
            ->setTable('products')
            ->setCustomRepositoryClass(ProductRepository::class)
            ->addIndex(['product_id'], 'productId')
            ->addUniqueConstraint(['product_id', 'shop_id','product_attribute_id','lang'], 'unique_product');

        $builder->addId();

        $builder->createField('name', 'string')
            ->build();

        $builder->createField('productId', 'integer')
            ->columnName('product_id')
            ->build();

        $builder->createField('productAttributeId', 'integer')
            ->columnName('product_attribute_id')
            ->nullable()
            ->build();

        $builder->createField('shopId', 'integer')
            ->columnName('shop_id')
            ->nullable()
            ->build();

        $builder->createField('taxPercent', 'float')
            ->columnName('tax_percent')
            ->nullable()
            ->build();

        $builder->createField('language', 'string')
            ->columnName('lang')
            ->build();

        $builder->createField('imageUrl', 'string')
            ->columnName('image_url')
            ->nullable()
            ->build();

        $builder->createField('url', 'string')
            ->nullable()
            ->build();

        $builder->addCategory();

        $builder->createField('shortDescription', 'string')
            ->columnName('short_description')
            ->nullable()
            ->build();

        $builder->createField('price', 'float')
            ->nullable()
            ->build();

        $builder->createField('reference', 'string')
            ->nullable()
            ->build();

        $builder->createField('longDescription', 'string')
            ->columnName('long_description')
            ->nullable()
            ->build();
    }

    public static function loadApiMetadata(ApiMetadataDriver $metadata)
    {
        $metadata->setGroupPrefix('product')
            ->addListProperties(
                [
                    'id',
                    'name',
                    'category',
                    'shopId',
                    'productId',
                    'language',
                ]
            )
            ->addProperties(
                [
                    'url',
                    'publishUp',
                    'publishDown',
                    'productAttributeId',
                    'reference',
                    'price',
                    'imageUrl',
                    'shortDescription',
                    'longDescription',
                ]
            )
            ->build();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function getProductAttributeId()
    {
        return $this->productAttributeId;
    }

    public function setProductAttributeId($productAttributeId)
    {
        $this->productAttributeId = $productAttributeId;
    }

    public function getShopId()
    {
        return $this->shopId;
    }

    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function getLongDescription()
    {
        return $this->longDescription;
    }

    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setLanguage($language)
    {
        $this->isChanged('language', $language);
        $this->language = $language;

        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setTaxPercent($taxPercent)
    {
        $this->taxPercent = $taxPercent;

        return $this;
    }

    public function getTaxPercent()
    {
        return $this->taxPercent;
    }
}