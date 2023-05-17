<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_Auth
 *
 * @author Yusda Helmani
 */

namespace App\Models;

use CodeIgniter\Model;

class Model_Auth extends Model
{
    //put your code here
    protected $table = 'user';
    protected $primaryKey = 'kd_user';
    
}
