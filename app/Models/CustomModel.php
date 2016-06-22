<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
class CustomModel extends Model
{
  public $timestamps=false;
  protected $connection="mysql";
  protected $errors,$attributeNames,$rules,$messages;
  protected $data;
  protected $guarded=['_token'];
  /**
   * validator base on rules
   * @param  array $data that want to validate
   * @return boolean
   */
  public function validate(array $data)
  {
     // make a new validator object
     $v = Validator::make($data, $this->rules,$this->messages);
     $v->setAttributeNames($this->attributeNames);
     // check for failure
      if ($v->fails())
      {
          // set errors and return false
          $this->errors = $v->errors();
          return false;
      }
      $this->data=$data;
      return true;
  }
  /**
   * insert data if validator true
   * @param  array $data
   */
  public function insertData(array $data){
    foreach($this->fillable as $value){
      if(array_key_exists($value,$data)){
        $this->$value=$data[$value];
      }
    }
    return $this->save();

  }
  public function updateData(){
    $this->insertData($this->data);
  }
  /**
   * getter error after validation
   * @return object errors
   */
  public function errors()
  {
     return $this->errors;
  }
  public function getAttributeNames(){
    return $this->attributeNames;
  }
  protected function setNumberFormat($value){
    return 'Rp. '.number_format($value,2,',','.');
  }
}
