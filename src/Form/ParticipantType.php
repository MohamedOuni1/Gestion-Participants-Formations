<?php

namespace App\Form;
use App\Entity\Formation;
use App\Entity\Image;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('email')
            ->add('telephone')
            ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'url',
            ])
            ->add('formation',EntityType::class,['class' => Formation::class,
                                            'choice_label' => 'titre']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}