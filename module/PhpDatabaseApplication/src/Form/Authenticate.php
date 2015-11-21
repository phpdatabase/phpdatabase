<?php

namespace PhpDatabaseApplication\Form;

use Zend\Form\Form;

class Authenticate extends Form
{
    /**
     * The profiles that the user can choose from.
     *
     * @var array
     */
    private $profiles;

    /**
     * Whether or not to display the default profile.
     *
     * @var bool
     */
    private $displayDefaultProfile;

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->profiles = [];
        $this->displayDefaultProfile = false;
    }

    public function init()
    {
        $this->add([
            'type' => 'Zend\\Form\\Element\\Hidden',
            'name' => 'authentication',
            'attributes' => [
                'value' => 'true',
            ],
        ]);

        if (count($this->profiles) > 1) {
            $this->add([
                'type' => 'Zend\\Form\\Element\\Select',
                'name' => 'profile',
                'options' => [
                    'label' => 'Profile',
                    'value_options' => $this->buildValueOptions(),
                ],
            ]);
        }

        $this->add([
            'type' => 'Zend\\Form\\Element\\Text',
            'name' => 'identity',
            'options' => [
                'label' => 'Username',
            ],
        ]);

        $this->add([
            'type' => 'Zend\\Form\\Element\\Password',
            'name' => 'credential',
            'options' => [
                'label' => 'Password',
            ],
        ]);

        $this->add([
            'type' => 'Zend\\Form\\Element\\Submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Login',
            ],
        ]);
    }

    public function setProfiles($profiles)
    {
        $this->profiles = $profiles;
    }

    public function setDisplayDefaultProfile($displayDefaultProfile)
    {
        $this->displayDefaultProfile = $displayDefaultProfile;
    }

    public function buildValueOptions()
    {
        $result = [];

        foreach ($this->profiles as $name => $profile) {
            if ($name === 'default' && !$this->displayDefaultProfile) {
                continue;
            }

            $result[$name] = $profile['display_name'];
        }

        return $result;
    }
}
