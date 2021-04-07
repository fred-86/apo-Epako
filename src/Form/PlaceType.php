<?php

namespace App\Form;

use App\Entity\Place;
use App\Entity\ProductCategory;
use App\Repository\PlaceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use App\Repository\ProductCategoryRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $placeHolder = !empty($options['attr']['placeImage']) ? $options['attr']['placeImage'] : 'Votre logo';
        $builder
            ->add('name')
            ->add('address')
            ->add('addressComplement')
            ->add('city')

            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                //'delete_label' => '...',
                //'download_label' => true,
                'download_uri' => false,
                'image_uri' => true,
                'imagine_pattern' => false,
                //'asset_helper' => true,
                'attr' => [
                    'placeholder' => $placeHolder
                ],
                //'empty_data' => 'Default value'
            ])

            ->add('status',ChoiceType::class,[
                'choices' => [
                    'Actif' => 0,
                    'Inactif' => 1,
                ],
                ])
            ->add('url')
            ->add('content')
            ->add('department')
            ->add('placeCategory')
            ->add('productCategories', EntityType::class,[
                'class' => ProductCategory::class,
                'constraints' => array(
                    new Count(array(
                        'max' => 1,
                        'maxMessage' => 'At least only 1 choice is required',
                    )),
                ),
                'expanded' => false,
                'multiple' => true,
                'query_builder' => function (ProductCategoryRepository $er) {
                    return $er->createQueryBuilder('pc')
                        ->where('pc.parent IS NOT NULL');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Place::class,

        ]);
    }
}
