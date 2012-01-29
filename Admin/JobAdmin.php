<?php

namespace COil\Jobeet2Bundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use COil\Jobeet2Bundle\Entity\Job;

class JobAdmin extends Admin
{
    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Offer')
                ->add('id')
                ->add('category')
                ->add('type')
                ->add('company')
                ->add('logo')
                ->add('url')
                ->add('position')
                ->add('location')
                ->add('description')
                ->add('howToApply')
                ->add('email')
            ->end()
            ->with('API')
                ->add('token')
                ->add('isPublic')
            ->end()
            ->with('System informations')
                ->add('isActivated')
                ->add('expiresAt')
                ->add('createdAt')
                ->add('updatedAt')
            ->end()
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Offer')
                ->add('category')
                ->add('type')
                ->add('company')
                ->add('logo')
                ->add('url')
                ->add('position')
                ->add('location')
                ->add('description')
                ->add('howToApply')
                ->add('email')
            ->end()
            ->with('API')
                ->add('token')     // Auto-generated but editable when not new
                ->add('isPublic')
            ->end()
            ->with('System informations')
                ->add('isActivated')
                ->add('expiresAt')   // Auto-generated but editable when not new
//                ->add('createdAt') // Auto-generated
//                ->add('updatedAt') // Auto-generated
            ->end()
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('category')
            ->add('type')
            //->add('company')  // ? https://github.com/sonata-project/SonataAdminBundle/issues/524
            ->add('isPublic', array(), array('label' => 'Public?'))
            ->add('isActivated', array(), array('label' => 'Activated?'))
            ->add('position')
            ->add('company')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     *
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('category')
            ->add('company')
            ->add('position')
            ->add('description')
            ->add('isActivated')
            ->add('isPublic')
            //->add('expiresAt')
        ;
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['extend'] = array(
            'label'            => $this->trans('action_extend'),
            'ask_confirmation' => true,
        );

        return $actions;
    }
}