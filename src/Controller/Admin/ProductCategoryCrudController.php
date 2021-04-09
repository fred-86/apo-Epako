<?php

namespace App\Controller\Admin;

use Doctrine\ORM\QueryBuilder;
use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductCategory::class;
    }

    /**
     * check doc
     *https://stackoverflow.com/questions/63432424/symfony-easyadminbundle-3-override-the-createindexquerybuilder
     *Permet pour l'index de n'aficher que les parents
     *
     */
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->where("entity.parent is null");
        return $response;
    }

    /**
     * selon la page
     * https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html#displaying-different-fields-per-page
     *
     * setFormTypeOptions
     * https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html#misc-options
     */

    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id')->onlyOnIndex();

        $childCategories = AssociationField::new('childCategories')
            ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
                return $productCategoryRepository->createQueryBuilder('pc')
                            ->where('pc.parent IS NOT NULL');

            })->setFormTypeOption('by_reference', false);


        $name = Field::new('name');
        $imageField = TextareaField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms()
        ->setTranslationParameters(['form.label.delete'=>'Delete'])
        ->setRequired(true);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name];
        } elseif (Crud::PAGE_EDIT === $pageName || Crud::PAGE_NEW === $pageName) {
            return [$id, $name,$imageField, $childCategories ];
        }
    }
   

}
