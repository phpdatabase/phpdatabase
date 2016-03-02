<?php

namespace PhpDatabaseApplication\Authentication;

class Identity
{
    /**
     * @var Profile[]
     */
    private $profiles;

    public function __construct()
    {
        $this->profiles = [];
    }

    public function addProfile(Profile $profile)
    {
        $this->profiles[] = $profile;
    }

    public function getProfiles()
    {
        return $this->profiles;
    }

    public function getConnection()
    {
        if (!$this->connection) {
            $identity = $this->getIdentity();
            var_dump(__METHOD__, $identity);
            exit;

            if (!$this->connectionManager->has($identity['platform'])) {
                throw new RuntimeException(sprintf('There is no connection registered for platform "%s".', $identity['platform']));
            }

            $this->connection = $this->connectionManager->get($identity['platform'], $identity);
        }

        return $this->connection;;
    }
}
