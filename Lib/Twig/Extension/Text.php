<?php

/**
 * @package Twig
 * @subpackage Twig-extensions
 */

namespace COil\Jobeet2Bundle\Lib\Twig\Extension;

class Text extends \Twig_Extension
{
    /**
     * Returns a list of filters.
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = array(
            'sha1' => new \Twig_Filter_Method($this, 'twigSha1Filter')
        );

        return $filters;
    }

    /**
     * Name of this extension
     *
     * @return string
     */
    public function getName()
    {
        return 'Text';
    }

    /**
     * Simply call the sha1 function.
     *
     * @param type $value
     * @return type
     */
    public function twigSha1Filter($value)
    {
        return sha1($value);
    }
}