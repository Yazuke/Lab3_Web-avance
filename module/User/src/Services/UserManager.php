<?php
namespace User\Services;

use Zend\Db\TableGateway\TableGatewayInterface;

class UserManager {
    protected $_tableGateway;

    public function __construct(TableGatewayInterface $tableGateway){
        $this->_tableGateway = $tableGateway;
    }

    public function findByUsername($username){
        return $this->_tableGateway->select(['username' => $username])->current();
    }
    public function findByMail($mail){
        return $this->_tableGateway->select(['mail' => $mail])->current();
    }

    public function changerMail($ancienMail,$nouveauMail){
        //Todo: vérif si nouveau mail pas existant
        $this->_tableGateway->update(['mail'=>$nouveauMail],['mail'=>$ancienMail]);
        return ;
    }
}
?>