<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Model\Panier;
use Application\Services\PanierTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PanierController extends AbstractActionController
{
    private $_table;

    public function __construct(PanierTable $table)
    {
        $this->_table = $table;
    }

    public function panierAction()
    {
        return new ViewModel([
            'panier' => $this->_table->fetchAll(),
        ]);
    }
}

