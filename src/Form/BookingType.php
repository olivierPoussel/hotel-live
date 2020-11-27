<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Customer;
use App\Entity\Room;
use App\Form\DataTransformer\DateTransformer;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    private $dateTransformer;

    public function __construct(DateTransformer $dateTransformer)
    {
        $this->dateTransformer = $dateTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', CustomerType::class)
            // ->add('startDate', DateType::class, ['widget' =>'single_text'])
            ->add('startDate', TextType::class, ['attr' => ['disabled' => true]])
            ->add('endDate', TextType::class, ['attr' => ['disabled' => true]])
            ->add('room', EntityType::class, [
                'class' => Room::class,
                'choice_label' => 'number',
                'choice_value' => 'id',
                'choice_attr' => function ($choice, $key, $value) {
                    return ['data-price' => $choice->getPrice()];
                }
                ])
            ->add('comment', TextareaType::class, [
                'required' => false,
            ])
            ->add('save', SubmitType::class)
        ;
        $builder->get('startDate')
                ->addModelTransformer($this->dateTransformer);
        $builder->get('endDate')
                ->addModelTransformer($this->dateTransformer);
        // ->addModelTransformer(new CallbackTransformer(
        //     function($date){
        //         if($date) {
        //             return $date->format('Y-m-d');
        //         }
        //     },
        //     function($dateString){
        //         if($dateString) {
        //             return DateTime::createFromFormat('Y-m-d', $dateString );

        //         }
        //     }
        //     )
        // );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
