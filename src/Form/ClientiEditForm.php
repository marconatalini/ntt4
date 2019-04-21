<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 09/02/2019
 * Time: 22:53
 */

namespace App\Form;

use App\Entity\Automezzi;
use App\Entity\Clienti;
use App\Entity\Ddts;
use App\Entity\ModoPagamento;
use App\Entity\Province;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientiEditForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codice', TextType::class, array('attr' => array('class' => 'form-control',)))
            ->add('sdi', TextType::class, array('attr' => array('class' => 'form-control',)))
            ->add('ragioneSociale', TextType::class, array('attr' => array('class' => 'form-control',)))
            ->add('pIva', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder'=>'11 numeri')))
            ->add('esenteIva', CheckboxType::class, array('required'=>false, 'attr' => array('class' => 'checkbox',)))
            ->add('indirizzo', TextType::class, array('required'=>false,'attr' => array('class' => 'form-control',)))
            ->add('cap', TextType::class, array('required'=>false,'attr' => array('class' => 'form-control',)))
            ->add('paese', TextType::class, array('required'=>false,'attr' => array('class' => 'form-control',)))
            ->add('provincia', EntityType::class, array(
                'class' => Province::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.sigla', 'ASC');
                },
                'choice_label' => 'sigla',
                'preferred_choices' => array('VR', 'VI'),
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('note', TextareaType::class, array('required'=>false, 'attr' => array('class' => 'form-control',)))
            ->add('um', TextType::class, array('required'=>false, 'attr' => array(
                'class' => 'form-control', 'placeholder'=>'Colli, Kg, Viaggi, Km...')))
            ->add('pagamento', EntityType::class, array(
                'class' => ModoPagamento::class,
                'choice_label' => 'pagamento',
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('spesaIncasso', MoneyType::class, array('attr' => array(
                'autocomplete'=>false, )))
            ->add('telefono', TextType::class, array('required'=>false,'attr' => array('class' => 'form-control',)))
            ->add('fax', TextType::class, array('required'=>false,'attr' => array('class' => 'form-control',)))
            ->add('email', TextType::class, array('required'=>false,'attr' => array('class' => 'form-control',)))
            ->add('pec', TextType::class, array('required'=>false,'attr' => array('class' => 'form-control',)))
            ->add('notaFattura', TextareaType::class, array('required'=>false, 'attr' => array('class' => 'form-control',)))


            ->add('submit', SubmitType::class, array('label' => 'Salva', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clienti::class,
        ]);
    }

}