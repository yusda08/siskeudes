<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

/**
 * Description of Model_input
 *
 * @author Yusda Helmani
 */
use CodeIgniter\Model;

class MY_Model extends Model {
    
    public function __construct(\CodeIgniter\Database\ConnectionInterface &$db = null, \CodeIgniter\Validation\ValidationInterface $validation = null) {
        parent::__construct($db, $validation);
        
    }

    function attrServerSide($builder, $column_search, $column_order, $orderBy) {
        $i = 0;
        foreach ($column_search as $item) { // loop column
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $builder->groupStart(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $builder->like($item, $_POST['search']['value']);
                } else {
                    $builder->orLike($item, $_POST['search']['value']);
                }
                if (count($column_search) - 1 == $i) //last loop
                    $builder->groupEnd(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) { // here order processing
            $builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($orderBy)) {
            $order = $orderBy;
            $builder->orderBy(key($order), $order[key($order)]);
        }
        return $builder;
    }

}
