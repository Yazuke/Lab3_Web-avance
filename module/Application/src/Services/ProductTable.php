<?php
namespace Application\Services;

use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\Product;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ProductTable {
    protected $_tableGateway;

    public function __construct(TableGatewayInterface $tableGateway){
        $this->_tableGateway = $tableGateway;
    }

    public function fetchAll($paginated=false) {
//        $resultSet = $this->_tableGateway->select();
//        $return = array();
//        foreach( $resultSet as $r )
//            $return[]=$r;
//        return $return;

        if ($paginated) {
            return $this->fetchPaginatedResults();
        }
        return $this->_tableGateway->select();
    }

    public function fetchPaginatedResults(){
        $select = new Select($this->_tableGateway->getTable());
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Product());
        $paginatorAdapter = new DbSelect(
            $select,
            $this->_tableGateway->getAdapter(),
            $resultSetPrototype
        );
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }



    public function insert($name,$description,$price){
        $tab=['name' => $name,'description' => $description,'price' => $price];
        $this->_tableGateway->insert($tab);
    }

    public function update($id,$name,$description,$price){
        //todo:vérification des champs
        $tab=['name' => $name,'description' => $description,'price' => $price];
        $this->_tableGateway->update($tab,['id' => $id]);
    }

    public function delete($id){
        $this->_tableGateway->delete(['id' => $id]);
    }


    public function find($id){
        $select=$this->_tableGateway->select(['id' => $id]);
        if(!$select){
            return false;
        }else{
            return $select->current();
        }
    }
}
?>