<?php

namespace Koyaan\BattleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class BattleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('video1')
            ->add('video2')
        ;
    }

    public function getName()
    {
        return 'koyaan_battlebundle_battletype';
    }
}
