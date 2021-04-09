<?php

namespace App\Controller\Admin;

use App\Entity\Place;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Place::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IntegerField::new('id')->onlyOnIndex(),
            Field::new('name'),
            TextareaField::new('content')->setRequired(true),
            Field::new('address')->hideOnIndex(),
            Field::new('addressComplement')->hideOnIndex(),
            Field::new('city')->setLabel("City / Système d'exploitation mobile" ),
            TextareaField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms()
            ->setTranslationParameters(['form.label.delete'=>'Delete'])->setRequired(true),
            ChoiceField::new('status')->setChoices([0 => 0, 1 => 1])->setHelp('0 = actif / 1 = inactif'),
            UrlField::new('url', 'URL Place')->hideOnIndex()->setRequired(true),
            AssociationField::new('department')->setRequired(true),
            AssociationField::new('placeCategory')->hideOnIndex()->setRequired(true),
        ];
    }

}
