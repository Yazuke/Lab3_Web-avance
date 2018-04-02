<?php
namespace Application\Controller\Factories;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;
use Zend\Authentication\Storage\Session as SessionStorage;
use Interop\Container\ContainerInterface;
use Application\Controller\PanierController;
use Application\Services\PanierTable;
use Application\Services\ProductTable;


/**
 * The factory responsible for creating of authentication service.
 */
class PanierControllerFactory implements FactoryInterface
{
    /**
     * This method creates the Zend\Authentication\AuthenticationService service
     * and returns its instance.
     */
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $panierTable = $container->get(\Application\Services\PanierTable::class);
        $productTable = $container->get(\Application\Services\ProductTable::class);

        return new PanierController($panierTable,$productTable);
    }
}
