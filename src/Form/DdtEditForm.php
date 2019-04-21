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
use App\Entity\Province;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DdtEditForm extends AbstractType
{

    private $session;
    private $em;
    private $reference;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->session = $session;
        $this->em = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $formModifier = function (FormInterface $form, $reference = null) {

            $this->reference = $reference;

            $form
                ->add('automezzo', EntityType::class, array(
                    'class' => Automezzi::class,
                    'choice_label' => 'targa',
                    'choice_value' => 'id',
                    'data' => $this->reference,
                ))
                ->add('numeroDdt', TextType::class)
                ->add('dataDdt', DateType::class, array('widget'=>'single_text','format'=>'dd/MM/yy', 'invalid_message' => 'Data non valida',
                    'attr' => array('placeholder'=>'31/01/19')))
                ->add('cliente', EntityType::class, array(
                    'class' => Clienti::class,
                    'choice_label' => 'codice',
                ))

                ->add('descrizione', TextareaType::class, array('attr' => array('row' => '5')))
                ->add('provincia', EntityType::class, array(
                    'class' => Province::class,
                    'choice_label' => 'sigla',
                    //'choice_value' => 'string',
                ))
                ->add('peso', TextType::class, array(
                    'required'=>false,))
                ->add('quantita', TextType::class)
                ->add('prezzoLire', NumberType::class, array(
                    'required'=>false, 'scale'=>2, 'mapped' => false,
                    'attr' => array(
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'title' => ''
                    )
                ))
                ->add('prezzo', MoneyType::class, array('attr' => array(
                        'autocomplete'=>false,))
                )
                ->add('salva', SubmitType::class);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                if ( null !== $this->session->get('last_mezzo')){
                    $reference = $this->em->getReference( Automezzi::class, $this->session->get('last_mezzo'));
                } elseif (null !== $event->getData()->getAutomezzo()) {
                    $reference = $this->em->getReference( Automezzi::class, $event->getData()->getAutomezzo()->getId());
                } else {
                    $reference = null;
                }
                $formModifier($event->getForm(), $reference);
            }
        );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ddts::class,
        ]);
    }

}