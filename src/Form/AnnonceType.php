<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
            ->add('Contenu')
            ->add('Date_Validite', DateType::class)
            ->add('rub_id',IntegerType::class, array('label'=>false))
            ->add('user_id',IntegerType::class,array('label'=>false))
            ->add('Image', FileType::class, ['mapped'=>false, 'required'=> false,"constraints"=> 
            new Image([
            'maxSize'=>'5M',
            // 'mimeTypes'=>['image/jpeg', 'image/png']
            'mimeTypesMessage'=>'Veuillez mettre une image valide'
            ])
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
