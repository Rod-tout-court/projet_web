<?php

namespace App\Form;

use App\Entity\Gif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\File;

class GifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('tags', null, [
                    'label' => 'Tags',
                    'attr' => ['class' => 'form-control'],
                ])
                ->add('gif', FileType::class, [
                    'label' => 'GIF (Fichier GIF)',
                    'mapped' => false,
                    'required' => true,
                    'constraints' => [
                        new File([
                            'maxSize' => '30M',
                            'mimeTypes' => [
                                'image/gif',
                                'application/x-tgif',
                            ],
                            'mimeTypesMessage' => 'Veuillez télécharger un fichier GIF valide',
                            'uploadErrorMessage' => 'Erreur lors du téléchargement du fichier',
                        ])
                    ],
                ]);
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gif::class,
            'user' => null, // Ajouter une option pour stocker l'utilisateur connecté
        ]);
    }

}
