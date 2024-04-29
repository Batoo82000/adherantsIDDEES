<?php

namespace App\Form;

use App\Classe\Search;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType { //Formulaire de notre recherche custom

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('string', TextType::class, [ // 1er champs qui sera une recherche textuelle
                'label' => false,
                'required' => false,
                'row_attr'=> [
                    'class'=>'form_row'
                ],
                'attr'=> [
                    'placeholder' => 'Rechercher par NOM ...',
                    'class'=> 'input'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Rechercher',
                'row_attr'=> [
                    'class'=>'btn_search'
                ],
                'attr'=> [
                    'class'=> 'btn'
                ]
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class, // La classe de données associée au formulaire est Search::class.
            'method'=> 'GET', // La méthode d'envoi du formulaire est définie sur "GET".
            'crsf_protection' => false, // a protection CSRF est désactivée (crsf_protection est défini sur false). Cela signifie que le formulaire ne générera pas automatiquement de jeton CSRF pour protéger contre les attaques CSRF.
        ]);
    }
    public function getBlockPrefix() //  Retourne une chaîne vide, ce qui signifie que le formulaire n'aura pas de préfixe. Cela signifie que les noms des champs dans le formulaire ne seront pas préfixés par le nom du formulaire lorsqu'ils sont rendus dans le HTML
    {
        return '';
    }
}
