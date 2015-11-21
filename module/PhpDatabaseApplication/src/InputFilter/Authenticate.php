<?php

namespace PhpDatabaseApplication\InputFilter;

use Zend\InputFilter\InputFilter;

class Authenticate extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'authentication',
            'required' => true,
            'validators' => [
                [
                    'name' => 'PhpDatabaseApplication\\Validator\\Authentication',
                    'options' => [],
                ]
            ],
        ]);

        $this->add([
            'name' => 'identity',
            'required' => false,
        ]);

        $this->add([
            'name' => 'credential',
            'required' => false,
        ]);

        $this->add([
            'name' => 'submit',
            'required' => false,
        ]);
    }
}
