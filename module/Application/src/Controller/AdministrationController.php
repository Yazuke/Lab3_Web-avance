<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Services\PanierTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Services\ProductTable;
use Application\Model\Product;

class AdministrationController extends AbstractActionController
{
    private $_table;
    private $_panierTable;

    public function __construct(ProductTable $table,PanierTable $panierTable)
    {
        $this->_table = $table;
        $this->_panierTable = $panierTable;
    }

    //affiche tout au chargement de /administration
    public function administrationAction()
    {
        return new ViewModel([
            'products' => $this->_table->fetchAll(),
        ]);
    }

    //lorsqu'on va sur administration/suppresion:id, supprime la ligne en bdd et redirige vers /administration
    public function suppressionAction(){

        $this->_panierTable->deleteAll($this->params()->fromRoute('id'));

        $this->_table->delete($this->params()->fromRoute('id'));
        return $this->redirect()->toRoute('administration');
    }

    public function ajoutAction(){

        //Récupère données du formulaire
        $request = $this->getRequest()->getPost();

        //Insere les données
        $this->_table->insert($request['name'],$request['description'],$request['price']);

        //Redirige vers /administration
        return $this->redirect()->toRoute('administration');
    }

    public function editionAction(){

    //Récupère données du formulaire
    $request = $this->getRequest()->getPost();

    //Insere les données
    $this->_table->update($request['id'],$request['name'],$request['description'],$request['price']);

    //Redirige vers /administration
    return $this->redirect()->toRoute('administration');
}


}
