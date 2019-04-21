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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ClientiSearchForm extends AbstractType
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codice', EntityType::class, [
                'class' => Clienti::class,
                'choice_label' => 'codice',
                'choice_value' => 'codice',
                'required' => false,
            ])
            ->add('ragioneSociale', TextType::class, [
                'required' => false
            ])
            ->add('email', TextType::class, [
                'required' => false
            ])
            ->add('cerca', SubmitType::class)
            ->setMethod('GET')
            ->setAction($this->router->generate(
                'clienti',
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