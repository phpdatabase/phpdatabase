<?php

namespace PhpDatabaseApplication\Authentication;

class Profile
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $platform;

    /**
     * @var string
     */
    private $displayName;

    /**
     * @var string
     */
    private $hostname;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * Initializes a new instance of the Profile class.
     *
     * @param string $displayName
     * @param string $hostname
     * @param string $name
     * @param string $password
     * @param string $platform
     * @param int $port
     * @param string $username
     */
    public function __construct($name, $platform, $displayName, $hostname, $port, $password, $username)
    {
        $this->name = $name;
        $this->platform = $platform;
        $this->displayName = $displayName;
        $this->hostname = $hostname;
        $this->port = $port;
        $this->password = $password;
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}
