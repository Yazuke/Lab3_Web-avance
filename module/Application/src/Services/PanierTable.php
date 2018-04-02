<?php
namespace Application\Services;

use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\Panier;

class PanierTable {
    protected $_tableGateway;
    private $authService;
    private $userManager;


    public function __construct(TableGatewayInterface $tableGateway, $authService,$userManager){
        $this->_tableGateway = $tableGateway;
        $this->authService = $authService;
        $this->userManager = $userManager;

    }

    public function fetchAll() {
        $resultSet = $this->_tableGateway->select();
        $return = array();
        foreach( $resultSet as $r )
            $return[]=$r;
        return $return;
    }

    public function fetchByUserConnected(){

        //Récupère id de l'utilisateur connecté
        $id=$this->userManager->findByUsername($this->authService->getIdentity())->_id;

        $resultSet=$this->_tableGateway->select(['idUser' => $id]);
        $return = array();
        foreach( $resultSet as $r )
            $return[]=$r;
        return $return;
    }


//
//    public function insert($name,$description,$price){
//        $tab=['name' => $name,'description' => $description,'price' => $price];
//        $this->_tableGateway->insert($tab);
//    }
//
//    public function update($id,$name,$description,$price){
//        //todo:vérification des champs
//        $tab=['name' => $name,'description' => $description,'price' => $price];
//        $this->_tableGateway->update($tab,['id' => $id]);
//    }
//
//    public function delete($id){
//        $this->_tableGateway->delete(['id' => $id]);
//    }
//
//
//    public function find($id){
//        return $this->_tableGateway->select(['id' => $id])->current();
//    }

}
?>