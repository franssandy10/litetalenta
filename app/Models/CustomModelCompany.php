<?php

namespace App\Models;

use App\Models\CustomModel;
use Config;
use Sentinel;
class CustomModelCompany extends CustomModel
{
    protected $connection="company";
    protected $columnNames;
    public function __construct($validate=false,$company_id=NULL,$attributes = array())
    {
      // if type only for validate
      if($validate==false&&$company_id==NULL){
        Config::set('database.connections.company.database',Config::get('app.database_name_company').Sentinel::getUser()->company_id_fk);
        parent::__construct($attributes);
      }
      else if($company_id){
        Config::set('database.connections.company.database',Config::get('app.database_name_company').$company_id);

      }

    }
    public static function setConn($company_id){
      Config::set('database.connections.company.database',Config::get('app.database_name_company').$company_id);

    }
    public function getDataTable(){
      return $this->select()->get();
    }

}
