<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\ProductCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductTendanceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    // public function configureCrud(Crud $crud): Crud
    // {
    //     return $crud->setSearchFields(null);
    // }


    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
        ;
    }

    public function configureFields(string $pageName): iterable
    {

        $categoryTendance = AssociationField::new('productCategories')
        ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
            return $productCategoryRepository->createQueryBuilder('pc')
                        ->where("pc.name LIKE '%endance%'");
        });

        return [
            IntegerField::new('id')->onlyOnIndex(),
            Field::new('name')->setFormTypeOption('disabled','disabled'),
            $categoryTendance->hideOnIndex()->setHelp('Choisir Tendance si le produit est en tendance ou laisser vide'),
        ];
    }

}
