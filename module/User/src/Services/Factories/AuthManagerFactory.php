<?php
namespace User\Services\Factories;

use Interop\Container\ContainerInterface;
use User\Services\UserPrivilegeTable;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Session\SessionManager;
use User\Services\AuthManager;
use User\Services\UserManager;

class AuthManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $authenticationService = $container->get(AuthenticationService::class);
        $sessionManager = $container->get(SessionManager::class);
        $userprivileges = $container->get(UserPrivilegeTable::class);

        return new AuthManager($authenticationService, $sessionManager, $userprivileges);
    }
}
