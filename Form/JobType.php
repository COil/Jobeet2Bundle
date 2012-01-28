<?php

namespace COil\Jobeet2Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use COil\Jobeet2Bundle\Entity\Job;

class JobType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('category', 'entity', array(
            'class'         => 'Jobeet2Bundle:Category',
            'required'      => true,
            'empty_value'   => ''
        ));

        $types = Job::getTypes();
        $builder->add('type', 'choice', array(
            'choices'   => $types,
            'required'  => true,
            'expanded'  => true
        ));

        $builder->add('company');
        $builder->add('logo', 'file', array(
            'required' => false,
        ));
        $builder->add('url', 'url');
        $builder->add('position');
        $builder->add('location');
        $builder->add('description', null, array('required' => true));
        $builder->add('howToApply', null, array('label' => 'How to apply ?'));
        $builder->add('isPublic', null, array('label' => 'Is public ?'));
        $builder->add('email', 'email');
    }

    public function getFields()
    {
        return array(
            'category',
            'type',
            'company',
            'logo',
            'url',
            'position',
            'location',
            'description',
            'howToApply',
            'isPublic',
            'email'
        );
    }

    public function getHelps()
    {
        return array(
            'isPublic' => 'Whether the job can also be published on affiliate websites or not',
        );
    }

    public function getName()
    {
        return 'job';
    }
}