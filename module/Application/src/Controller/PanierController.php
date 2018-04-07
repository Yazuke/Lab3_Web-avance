<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Model\Panier;
use Application\Services\PanierTable;
use Application\Services\ProductTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PanierController extends AbstractActionController
{
    private $_panierTable;
    private $_productTable;

    public function __construct(PanierTable $panierTable, ProductTable $productTable)
    {
        $this->_panierTable = $panierTable;
        $this->_productTable = $productTable;
    }

    public function panierAction()
    {
        $index=0;

        //Récupère les objets Product qui ont l'id récupéré dans Panier (permet d'afficher leur nom, prix etc)
        foreach ($this->_panierTable->fetchByUserConnected() as $panier){
            $find=$this->_productTable->find($panier->_idProduct);
            if($find){
                $produits[$index]=$find;
                $index++;
            }

        }

        //Si le panier a des éléments, on lui renvoie tout, sinon, on lui renvoie juste le nombre d'éléments (=0)
        if($index>0){
            return new ViewModel([
                'paniers' => $this->_panierTable->fetchByUserConnected(),
                'produits'=> $produits,
                'indexMax'=> $index
            ]);
        }else{
            return new ViewModel([
                'indexMax'=> $index
            ]);
        }
    }

    public function ajoutPanierAction(){

        $this->_panierTable->insert($this->params()->fromRoute('id'));

        return $this->redirect()->toRoute('home');
    }

    public function suppressionPanierAction(){

        $this->_panierTable->delete($this->params()->fromRoute('id'));

        return $this->redirect()->toRoute('panier');
    }

}

