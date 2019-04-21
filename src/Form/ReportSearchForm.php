<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 07/02/2019
 * Time: 00:37
 */

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ReportSearchForm extends AbstractType
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $anni = range((int) date('Y'), 2008 );

        $builder
            ->add('anno', ChoiceType::class, [
                'choices' => array_combine($anni, $anni),
            ])
            ->add('mese', ChoiceType::class, [
                'choices' => [
                    'Gennaio' => '01',
                    'Febbraio' => '02',
                    'Marzo' => '03',
                    'Aprile' => '04',
                    'Maggio' => '05',
                    'Giugno' => '06',
                    'Luglio' => '07',
                    'Agosto' => '08',
                    'Settembre' => '09',
                    'Ottobre' => '10',
                    'Novembre' => '11',
                    'Dicembre' => '12',
                ],
                'placeholder' => 'mese...',
                'required' => false,
            ])

            ->add('Estrai', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => array('class' => 'form-inline')
        ]);
    }



}