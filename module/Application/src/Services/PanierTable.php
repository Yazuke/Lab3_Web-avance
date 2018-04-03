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
        $id=$this->userManager->findByMail($this->authService->getIdentity())->_id;

        $resultSet=$this->_tableGateway->select(['idUser' => $id]);
        $return = array();
        foreach( $resultSet as $r )
            $return[]=$r;
        return $return;
    }

    public function getUserConnected(){
        return $this->userManager->findByMail($this->authService->getIdentity())->_id;
    }



    public function insert($idProduct){
        //Récupère l'id de l'utilisateur connecté
        $idUser=$this->getUserConnected();

        //Teste si l'entrée existe déjà
        $testExistence=$this->_tableGateway->select(['idUser' => $idUser,'idProduct'=>$idProduct]);

        //Si une entrée existe déjà, on augmente la quantité du produit et on update
        if($testExistence->count()>0){

            foreach ($testExistence as $test){
                $quantity=$test->_quantity+1;
                $id=$test->_id;
            }

            $tab=['idUser' => $idUser,'idProduct' => $idProduct,'quantity'=>$quantity];
            $this->_tableGateway->update($tab,['id'=>$id]);

        //Sinon, on insere une nouvelle ligne avec une quantité de 1
        }else{
            $quantity=1;

            $tab=['idUser' => $idUser,'idProduct' => $idProduct,'quantity'=>$quantity];
            $this->_tableGateway->insert($tab);
        }
    }

//    public function exists($idUser,$idProduct){
//        return $resultSet=$this->_tableGateway->select(['idUser' => $idUser,'idProduct'=>$idProduct]);
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