<?php
namespace App;
use Sentinel;
use Hash;
use App\Models\User;
use Carbon\Carbon;
class CustomValidator{
  /**
   * [alphaSpaces validations for after space after alphas]
   * @param  $attribute  [name attribute]
   * @param  $value      [value of attribute]
   * @param  [array] $parameters []
   * @return [boolean]
   */
  public function alphaSpaces($attribute,$value,$parameters,$validator){
    // return preg_match('/^[\pL\s]+$/u', $value);
     return preg_match('/\w+\s\w+.*$/', $value);

  }
  /**
   * [passwordValidator for validate must contain number,uppercase,lowercase]
   * @param  $attribute  [name attribute]
   * @param  $value      [value of attribute]
   * @param  [array] $parameters []
   * @return [boolean]
   */
  public function passwordValidator($attribute,$value,$parameters,$validator){
    return preg_match('/^[A-Z].*[a-z].*[0-9].*|[A-Z].*[0-9].*[a-z].*|[a-z].*[A-Z].*[0-9].*|[a-z].*[0-9].*[A-Z].*|[0-9].*[a-z].*[A-Z].*|[0-9].*[A-Z].*[a-z].*$/',$value);
  }
  public function checkCurrentPassword($attribute,$value,$parameters,$validators){
    return Hash::check($value, Sentinel::getUser()->password);
  }
  public function checkFileType($attribute,$value,$parameters,$validators){
    $dotPosition=strrpos($value, '.');
    $extension=substr($value,$dotPosition+1);
    $extensionArray=['jpg','jpeg','png'];
    return in_array($extension,$extensionArray);
  }
  /**
   * [uniqueEmail validator if only user set for his/herself]
   * @param  [type] $attribute  [description]
   * @param  [type] $value      [description]
   * @param  [type] $parameters [description]
   * @param  [type] $validators [description]
   * @return [type]             [description]
   */
  public function uniqueEmail($attribute,$value,$parameters,$validators){
    $query=User::where('email',$value);
    $firstRegister=array_get($validators->getData(), $parameters[0], null);
    if($firstRegister=='yes'){
      $query->where('email','!=',Sentinel::getUser()->email);
    }
    $result=$query->first();
    if($result){
      return false;
    }
    return true;
  }
  public function moreThanOtherDate($attribute,$value,$parameters,$validators){
    if($value){
      // print_r($attribute);exit;
      // get join date from validator
      $joinDate= array_get($validators->getData(), $parameters[0], null);
      $firstDate=Carbon::createFromFormat('Y-m-d',$value);
      $secondDate=Carbon::createFromFormat('Y-m-d',$joinDate);
      if($secondDate->gt($firstDate)){

        // if join date lebih kecil dari tanggal yang diharuskan
        return false;
      }
      else{
        // if join date lebih besar dari tanggal yang diset jadinya error
        return true;
      }
    }
    return true;
  }
}
/*
* app/validators.php
*/
