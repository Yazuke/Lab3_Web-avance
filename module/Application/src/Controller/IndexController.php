<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Services\ProductTable;

class IndexController extends AbstractActionController
{
    private $_table;

    public function __construct(ProductTable $table)
    {
        $this->_table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'products' => $this->_table->fetchAll(),
        ]);
    }
}
