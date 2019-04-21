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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FattureAddForm extends AbstractType
{
    private $dataFattura;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $formModifier = function (FormInterface $form, $dataFattura = null) {

            $this->dataFattura = $dataFattura;

            if (!null == $dataFattura) {
                $form->add('dataFattura', DateType::class,[
                    'widget' => 'single_text',
                    'input' => 'string',
                    'required' => false,
                    'attr' => ['value' => $dataFattura ]
                ]);
            } else {
                $form->add('dataFattura', DateType::class,[
                    'widget' => 'single_text',
                    'input' => 'string',
                    'required' => false,
                    'attr' => ['max' => date('Y-m-d', strtotime('now')),
                        'min' => date('Y-m-d', strtotime('-60 days')),
                        'value' => date('Y-m-d', strtotime('now'))]
                ]);
            }

            $form->add('Estrai', SubmitType::class);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                if ( isset($_POST['fatture_add_form']['dataFattura'])){
                    $dataFattura = $_POST['fatture_add_form']['dataFattura'];
                } else {
                    $dataFattura = null;
                }
                $formModifier($event->getForm(), $dataFattura);
            }
        );
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => array('class' => 'form-inline')
        ]);
    }



}