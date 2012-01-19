<?php

/**
 * This class contains tools methods.
 */

namespace COil\Jobeet2Bundle\Lib;

class Jobeet
{
  static public function slugify($text)
  {
    // replace all non letters or digits by -
    $text = preg_replace('/\W+/', '-', $text);

    // trim and lowercase
    $text = strtolower(trim($text, '-'));

    return $text;
  }
}