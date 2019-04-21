<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 07/02/2019
 * Time: 00:37
 */

namespace App\Form;

use App\Entity\Clienti;
use App\Entity\Fatture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProspettiSearchForm extends AbstractType
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
            ->add('estrai', SubmitType::class, [
                'attr' => ['value'=>'estrai']
            ])
            ->add('pdf', SubmitType::class, [
                'attr' => ['value'=>'pdf']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => array('class' => 'form-inline')
        ]);
    }



}