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

        $paginated=true;

        // grab the paginator from the AlbumTable
        $paginator = $this->_table->fetchAll($paginated);

        if($paginated){
            // set the current page to what has been passed in query string, or to 1 if none set
            $paginator->setCurrentPageNumber((int) $this->params()->fromRoute('page', 1));
            // set the number of items per page to 10
            $paginator->setItemCountPerPage(8);
        }

        return new ViewModel([
            'products' => $paginator,
            'paginated'=> $paginated
        ]);
    }

    public function redirectAction(){
        return $this->redirect()->toRoute('paginator');
    }
}
