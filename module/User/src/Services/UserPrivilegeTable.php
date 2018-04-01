<?php
namespace User\Services;

use Zend\Db\TableGateway\TableGatewayInterface;

class UserPrivilegeTable {
    protected $_tableGateway;

    public function __construct(TableGatewayInterface $tableGateway){
        $this->_tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->_tableGateway->select();
        $return = array();
        foreach( $resultSet as $r )
            $return[]=$r;
        return $return;
    }

    public function findById($idUser){
        return $this->_tableGateway->select(['idUser' => $idUser])->current();
    }

}
?>