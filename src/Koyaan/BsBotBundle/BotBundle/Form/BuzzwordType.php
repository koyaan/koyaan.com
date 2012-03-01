<?php

namespace Koyaan\BsBotBundle\BotBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class BuzzwordType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('word')
        ;
    }

    public function getName()
    {
        return 'koyaan_bsbotbundle_botbundle_buzzwordtype';
    }
}
