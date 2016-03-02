<?php

namespace PhpDatabaseApplication\Authentication\Adapter;

use Exception;
use PhpDatabaseApplication\Authentication\Service\ConnectionPluginManager;
use RuntimeException;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;

class AuthenticationAdapter extends AbstractAdapter
{
    /**
     * The connection manager that is used to build connections.
     *
     * @var ConnectionPluginManager
     */
    private $connectionManager;

    /**
     * The profiles that are available.
     *
     * @var array
     */
    private $availableProfiles;

    /**
     * The name of the profile to validate.
     *
     * @var string
     */
    private $profile;

    public function __construct(ConnectionPluginManager $connectionManager, array $availableProfiles)
    {
        $this->connectionManager = $connectionManager;
        $this->availableProfiles = $availableProfiles;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    public function authenticate()
    {
        if (!array_key_exists($this->profile, $this->availableProfiles)) {
            return new Result(Result::FAILURE, $this->getIdentity());
        }

        $profile = $this->availableProfiles[$this->profile];

        if (!array_key_exists('platform', $profile)) {
            throw new RuntimeException('Missing "platform" property in profile.');
        }

        if (!array_key_exists('hostname', $profile)) {
            throw new RuntimeException('Missing "hostname" property in profile.');
        }

        if (!array_key_exists('port', $profile)) {
            throw new RuntimeException('Missing "port" property in profile.');
        }

        $identity = $this->buildIdentity($profile);

        if (!$this->tryConnect($profile['platform'], $identity)) {
            return new Result(Result::FAILURE, $this->getIdentity());
        }

        return new Result(Result::SUCCESS, $identity);
    }

    private function buildIdentity($profile)
    {
        return $profile + [
            'username' => $this->getIdentity(),
            'password' => $this->getCredential(),
            'name' => $this->profile,
        ];
    }

    private function tryConnect($platform, array $identity)
    {
        if (!$this->connectionManager->has($platform)) {
            return false;
        }

        try {
            $connection = $this->connectionManager->get($platform, $identity);
            $connection->ping();
        } catch (Exception $ex) {
            return false;
        }

        return true;
    }
}
