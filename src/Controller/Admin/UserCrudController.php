<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {

        return [
            IntegerField::new('id')->onlyOnIndex(),
            EmailField::new('email'),
            ChoiceField::new('roles')->allowMultipleChoices(true)
            ->setChoices(['ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_USER' => 'ROLE_USER', 'ROLE_MANAGER' => 'ROLE_MANAGER']),
            Field::new('nickname'),
            ChoiceField::new('status')->setChoices([0 => 0, 1 => 1, 2 => 2 ])->setHelp('0 = actif / 1 = inactif / 2 = banned'),
            //solution pour encoder le password https://grafikart.fr/forum/33951
            Field::new('password')->setFormType(PasswordType::class)->hideOnIndex()->onlyWhenCreating(),
        ];
    }
}
