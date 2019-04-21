<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 07/02/2019
 * Time: 00:37
 */

namespace App\Form;

use App\Entity\Clienti;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DdtSearchForm extends AbstractType
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('data', DateType::class, [
                'widget' => 'single_text',
                'input' => 'string',
                'required' => true,
                'attr' => ['name' => 'data']
            ])
            ->add('numero', IntegerType::class, [
                'required' => false,
                'attr' => ['name' => 'numero']
            ])
            ->add('cliente', EntityType::class, [
                'class' => Clienti::class,
                'choice_label' => 'codice',
                'required' => false,
            ])
            ->add('sortBy', ChoiceType::class, [
                'choices'  => [
                    'per data' => 'dataDdt',
                    'per prezzo' => 'prezzo',
                ],
                'required' => false,
                'label' => 'Ordina per'
            ])
            ->add('order', ChoiceType::class, [
                'choices'  => [
                    'A->Z' => 'ASC',
                    'Z->A' => 'DESC',
                ],
                'required' => false,
                'label' => false,
            ])
            ->add('cerca', SubmitType::class)
            ->setMethod('GET')
            ->setAction($this->router->generate(
                'ddts',
                ['slug' => ''])
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => array('class' => 'form-inline')
        ]);
    }



}