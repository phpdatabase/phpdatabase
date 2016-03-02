<?php

namespace PhpDatabaseApplication\Controller;

use PhpDatabaseApplication\Authentication\AuthenticationService;
use PhpDatabaseApplication\Form\Authenticate;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Authentication extends AbstractActionController
{
    private $authenticateForm;
    private $authenticationService;

    public function __construct(AuthenticationService $authenticationService, Authenticate $authenticateForm)
    {
        $this->authenticationService = $authenticationService;
        $this->authenticateForm = $authenticateForm;
    }

    public function loginAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->authenticateForm->setData($this->getRequest()->getPost());

            if ($this->authenticateForm->isValid()) {
                return $this->redirect()->toRoute('dashboard');
            }
        }

        return new ViewModel([
            'authenticateForm' => $this->authenticateForm,
        ]);
    }

    public function logoutAction()
    {
        $connection = $this->params()->fromQuery('connection', null);

        if ($connection === null) {
            $this->authenticationService->clearIdentity();
        } else {
            $this->authenticationService->clearConnection($connection);
        }

        return $this->redirect()->toRoute('login');
    }
}
