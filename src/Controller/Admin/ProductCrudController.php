<?php

namespace App\Controller\Admin;
use App\Entity\Product;
use App\Repository\ProductCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    // public function configureCrud(Crud $crud): Crud
    // {
    //     return $crud->setSearchFields(null);
    // }

    public function configureFields(string $pageName): iterable
    {

        $subproductCategories = AssociationField::new('productCategories', 'subcategory')
            ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
                return $productCategoryRepository->createQueryBuilder('pc')
                            ->where('pc.parent IS NOT NULL');
            });


            // $subproductCategories = AssociationField::new('productCategories', 'subcategory')
        //     ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
        //         return $productCategoryRepository->createQueryBuilder('pc')
        //                     ->where('pc.parent IS NOT NULL');
        //     });

        // $subproductCategories = ChoiceField::new('productCategories', 'subcategory')
        // ->setChoices( function (ProductCategory $productCategory, ProductCategoryRepository $productCategoryRepository, EntityManagerInterface $em) {
        //     return $productCategoryRepository->findAllNameSubCategoryWithoutTendance($em);
        // });

        // public function findAllNameSubCategoryWithoutTendance(EntityManagerInterface $em)
        // {
        //    $qb = $em->createQueryBuilder();
        //    $qb->getEntityManager();
        //    $listSubCategories = $qb->select('pc.name')
        //        ->from('product_category', 'pc')
        //        ->where('pc.parent IS NULL')->andwhere("pc.name NOT LIKE '%endance%'");

        //    return $listSubCategories;
        // }

        // $em = $this->get(EntityRepository::class);
        // $em->createQueryBuilder();
        // $listSubCategories =$em->findAllNameSubCategoryWithoutTendance();

        //$response = $this->get(EntityRepository::class);

        //  $em = $this->get(EntityManagerInterface::class);
        //  $qb = $em->createQueryBuilder();
        //  $listSubCategories = $qb->select('pc.name')
        //     ->from('product_category', 'pc')
        //     ->where('pc.parent IS NULL')->andwhere("pc.name NOT LIKE '%endance%'");

        //  $listSubCategories = $this->getDoctrine()->getRepository(ProductCategory::class)
        //         ->select('pc.name')
        //          ->from('product_category', 'pc')
        //          ->where('pc.parent IS NULL')->andwhere("pc.name NOT LIKE '%endance%'");

        //                             $parent = AssociationField::new('parent')
        // ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
        //     return $productCategoryRepository->createQueryBuilder('pc')
        //                 ->where('pc.parent IS NULL')->andwhere("pc.name NOT LIKE '%endance%'");

        //});

        // return $this->createQueryBuilder('p')
        // ->innerJoin('places.productCategories','pc')
        // ->andWhere('pc.id = :val')
        // ->setParameter('val', $value)
        // ->getQuery()
        // ->getResult()

        return [
            IntegerField::new('id')->onlyOnIndex(),
            Field::new('name'),
            TextareaField::new('content')->hideOnIndex(),
            IntegerField::new('price'),
            ChoiceField::new('status')->setChoices([0 => 0, 1 => 1])->setHelp('0 = actif / 1 = inactif'),
            Field::new('brand'),
            AssociationField::new('images')->setFormTypeOption('by_reference', false)
            ->hideOnIndex(),
            $subproductCategories->setHelp('Choisir une seule subcategory')//->setFormTypeOptions(['multiple' => false])
            ->setRequired(true)->hideOnIndex(),
        ];
    }

}
