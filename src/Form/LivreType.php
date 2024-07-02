<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Livre;
use App\Entity\Category;
use App\Repository\EtatRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content')
            //->add('createdAt')
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                'choice_label'=>'description',
            ])
            ->add('etat',EntityType::class,[
                'class'=>Etat::class,
                'choice_label'=>'statut',
                'query_builder' => function (EtatRepository $er) {
                    return $er->createQueryBuilder('e')
                    ->Where("e.id<3")
                    ->orderBy('e.statut', 'DESC');
                },                   
            ])
            ->add('fichierimage',FileType::class,[
                'mapped'=>false,
                'label'=>'Choisir Image du Livre',
                'required'=>false,
                'constraints'=>[
                    new File([
                    'maxSize'=>'1024k',
                    'mimeTypes'=>['image/jpeg'],
                    'mimeTypesMessage'=>'SVP Uploadez un fichier jpeg valide'
                    ])
                ]
            ])

            ->add('fichieraudio',FileType::class,[
                'mapped'=>false,
                'label'=>'Ajout fichier Audio pour le livre audio',
                'constraints'=>[
                    new File([
                    'mimeTypesMessage'=>'SVP Uploadez un fichier audio valide'
                    ])
                ]
            ])

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}