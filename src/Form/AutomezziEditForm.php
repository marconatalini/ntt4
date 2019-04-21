<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 09/02/2019
 * Time: 22:53
 */

namespace App\Form;

use App\Entity\Automezzi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutomezziEditForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('targa', TextType::class, array('attr' => array('class' => 'form-control',)))
            ->add('modello', TextType::class, array('attr' => array('class' => 'form-control',)))
            ->add('dataAcquisto', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dismesso', CheckboxType::class, array('required'=>false, 'attr' => array('class' => 'checkbox',)))
            ->add('dataBollo', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dataRevisione', DateType::class,  [
                'widget' => 'single_text',
            ])

            ->add('submit', SubmitType::class, array('label' => 'Salva', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Automezzi::class,
        ]);
    }

}