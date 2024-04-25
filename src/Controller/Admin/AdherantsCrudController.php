<?php

namespace App\Controller\Admin;

use App\Entity\Adherants;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AdherantsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adherants::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),
            TextField::new('nom', 'Saisissez le nom (obligatoire) :')
                ->setRequired(true),
            TextField::new('prenom', 'Saisissez le prénom (obligatoire) :' )
                ->setRequired(true),
            TextField::new('adresse', 'Saisissez l\'adresse (obligatoire) :')
                ->setRequired(true)
            ->hideOnIndex(),
            IntegerField::new('codePostal', 'Saisissez le code postal (obligatoire) :')
                ->setRequired(true),
            TextField::new('ville', 'Saisissez la ville (obligatoire) :')
                ->setRequired(true),
            IntegerField::new('telephone', 'Saisissez le numéro de téléphone :')
            ->hideOnIndex(),
            EmailField::new('email', 'Saisissez l\'email :')
            ->hideOnIndex(),
            DateField::new('dateAdhesion')->setFormat('dd.MM.yyyy')
                ->setRequired(true),
            AssociationField::new('site', 'Choisissez le lieu où est rattaché la carte (obligatoire) :')
                ->setRequired(true)
            ->hideOnIndex(),
            ChoiceField::new('cotisation')
                ->hideOnIndex()
                ->hideOnIndex()
                ->setLabel('Saisissez le mode de paiement de la cotisation (obligatoire) :')
                ->setRequired(true)
                ->allowMultipleChoices()
                ->setChoices([
                    'Espèces' => 'Espèces',
                    'Chèque' => 'Chèque',
                    'Carte bancaire' => 'Carte bancaire',
                ])
                ->setFormTypeOptions([
                    'multiple' => false,
                    'expanded' => true,
                ]),
            ChoiceField::new('lieuCotisation')
                ->hideOnIndex()
                ->hideOnIndex()
                ->setLabel('Saisissez le mode de la cotisation (obligatoire) :')
                ->setRequired(true)
                ->allowMultipleChoices()
                ->setChoices([
                    'Magasin' => 'Magasin',
                    'Bureau' => 'Bureau',
                    'Agent de collecte' => 'Agent de collecte',
                ])
                ->setFormTypeOptions([
                    'multiple' => false,
                    'expanded' => true,
                ])
        ];
    }

}
