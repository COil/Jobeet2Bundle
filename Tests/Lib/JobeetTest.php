<?php

namespace COil\Jobeet2Bundle\Tests\Lib;

use COil\Jobeet2Bundle\Lib\Jobeet;

class JobeetTest extends \PHPUnit_Framework_TestCase
{
    public function testSlugify()
    {
        $this->assertEquals(Jobeet::slugify('Sensio'), 'sensio', '::slugify() converts all characters to lower case');
        $this->assertEquals(Jobeet::slugify('sensio labs'), 'sensio-labs', '::slugify() replaces a white space by a -');
        $this->assertEquals(Jobeet::slugify('sensio   labs'), 'sensio-labs', '::slugify() replaces several white spaces by a single -');
        $this->assertEquals(Jobeet::slugify('  sensio'), 'sensio', '::slugify() removes - at the beginning of a string');
        $this->assertEquals(Jobeet::slugify('sensio  '), 'sensio', '::slugify() removes - at the end of a string');
        $this->assertEquals(Jobeet::slugify('paris,france'), 'paris-france', '::slugify() replaces non-ASCII characters by a -');
        $this->assertEquals(Jobeet::slugify(' - '), 'n-a', '::slugify() converts a string that only contains non-ASCII characters to n-a');

        if (function_exists('iconv'))
        {
            $this->assertEquals(Jobeet::slugify('Développeur Web'), 'developpeur-web', '::slugify() removes accents');
        }
        else
        {
            $this->markTestSkipped('::slugify() removes accents - iconv not installed');
        }
    }
}