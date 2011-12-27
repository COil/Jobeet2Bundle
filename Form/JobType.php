<?php

namespace COil\Jobeet2Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class JobType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('company', null, array('required' => true))
            ->add('logo')
            ->add('url')
            ->add('position')
            ->add('location')
            ->add('description')
            ->add('howToApply')
            ->add('token')
            ->add('isPublic')
            ->add('isActivated')
            ->add('email')
            ->add('expiresAt')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('category')
        ;
    }

    public function getName()
    {
        return 'job';
    }
}
