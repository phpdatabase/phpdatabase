<?php

namespace PhpDatabaseApplication\Validator;

use PhpDatabaseApplication\Authentication\Adapter\AuthenticationAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Validator\AbstractValidator;

class Authentication extends AbstractValidator
{
    /**
     * Error codes
     * @const string
     */
    const NOT_VALID = 'notValid';
    const IDENTITY_NOT_FOUND = 'identityNotFound';
    const IDENTITY_AMBIGUOUS = 'identityAmbiguous';
    const CREDENTIAL_INVALID = 'credentialInvalid';
    const UNCATEGORIZED = 'uncategorized';
    const GENERAL = 'general';

    /**
     * Error Messages
     * @var array
     */
    protected $messageTemplates = [
        self::NOT_VALID => 'Cannot log in to the server.',
        self::IDENTITY_NOT_FOUND => 'Invalid identity',
        self::IDENTITY_AMBIGUOUS => 'Identity is ambiguous',
        self::CREDENTIAL_INVALID => 'Invalid password',
        self::UNCATEGORIZED => 'Authentication failed',
        self::GENERAL => 'Authentication failed',
    ];

    /**
     * The authentication service used to authenticate the user.
     *
     * @var AuthenticationService
     */
    private $authenticationService;

    public function setAuthenticationService(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function isValid($value, $context = null)
    {
        $this->setValue($value);

        /* @var $adapter AuthenticationAdapter */
        $adapter = $this->authenticationService->getAdapter();
        $adapter->setProfile($context['profile']);
        $adapter->setIdentity($context['identity']);
        $adapter->setCredential($context['credential']);

        $result = $this->authenticationService->authenticate($adapter);

        switch ($result->getCode()) {
            case Result::SUCCESS:
                break;

            case Result::FAILURE_IDENTITY_NOT_FOUND:
                $this->error(self::IDENTITY_NOT_FOUND);
                break;

            case Result::FAILURE_CREDENTIAL_INVALID:
                $this->error(self::CREDENTIAL_INVALID);
                break;

            case Result::FAILURE_IDENTITY_AMBIGUOUS:
                $this->error(self::IDENTITY_AMBIGUOUS);
                break;

            case Result::FAILURE_UNCATEGORIZED:
                $this->error(self::UNCATEGORIZED);
                break;

            default:
                $this->error(self::GENERAL);
                break;
        }

        return $result->getCode() === Result::SUCCESS;
    }
}
