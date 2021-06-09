<?php

namespace MauticPlugin\EcommerceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;

class ProductCategory{

    private $id;

    private $categoryId;

    private $parent;

    private $shopId;

    private $isRoot;

    private $depth;

    private $name;

    private $description;

    private $language;

    private $children;

    private $products;


    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public static function loadMetadata(ORM\ClassMetadata $metadata): void
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->addId();

        $builder
            ->setTable('product_categories')
            ->setCustomRepositoryClass(ProductCategoryRepository::class)
            ->addUniqueConstraint(['category_id', 'shop_id', 'lang'], 'unique_product');;

        $builder->createField('categoryId', 'integer')
            ->columnName('category_id')
            ->build();

        $builder->createField('name', 'string')
            ->build();

        $builder->createField('description', 'string')
            ->columnName('description')
            ->nullable()
            ->build();

        $builder->createField('shopId', 'integer')
            ->columnName('shop_id')
            ->build();

        $builder->createField('depth', 'integer')
            ->build();

        $builder->createField('isRoot', 'boolean')
            ->columnName('is_root')
            ->build();

        $builder->createManyToOne('parent', 'ProductCategory')
            ->inversedBy('children')
            ->addJoinColumn('parent_id', 'id', true, false)
            ->build();

        $builder->createManyToMany('products', 'Product')
            ->setJoinTable('product_category_products')
            ->addInverseJoinColumn('product_id', 'id', false)
            ->build();

        $builder->createField('language', 'string')
            ->columnName('lang')
            ->build();

        $builder->createManyToMany('children', 'ProductCategory')
            ->setJoinTable('product_category_childrens')
            ->addInverseJoinColumn('children_id', 'id', false)
            ->build();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getShopId()
    {
        return $this->shopId;
    }

    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
    }

    public function getParentId()
    {
        return $this->parent;
    }

    public function setParent(ProductCategory $parent)
    {
        $this->parent = $parent;
    }

    public function getIsRoot()
    {
        return $this->isRoot;
    }

    public function setIsRoot($isRoot)
    {
        $this->isRoot = $isRoot;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDepth()
    {
        return $this->depth;
    }

    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function getChildrens()
    {
        return $this->children;
    }

    public function setChildren(ProductCategory $childrens)
    {
        $this->children[] = $childrens;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function setProduct(Product $products)
    {
        $this->products = $products;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function setCategoryId( $categoryId)
    {
        $this->categoryId = $categoryId;
    }

}