<?php
namespace User\Services\Factories;

use Interop\Container\ContainerInterface;
use User\Models\UserPrivilege;
use User\Services\AuthAdapter;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Services\UserManager;
use User\Services\UserPrivilegeTable;

class AuthAdapterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $table = $container->get(UserManager::class);
        $table2 = $container->get(UserPrivilegeTable::class);

        return new AuthAdapter($table,$table2);
    }
}
