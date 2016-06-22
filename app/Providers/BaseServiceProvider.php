<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Request;
use App\Models\CompanyRegulationJkk;
class BaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    public static function setNullArray(array $data){
      foreach($data as $key=> $value){
        if($value===""){
          unset($data[$key]);
        }
      }
      return $data;
    }
    public static function getDataJkk($id=NULL){
     $list=[''=>'-Select-']+CompanyRegulationJkk::lists('jkk','description')->all();

      // $dataJkk=[1=>' - 1.74%',2=>'5 - 1.72%'];
      return $list;
    }
    public static function getGender(){
      $list=[''=>'-Select-',1=>'Male',2=>'Female'];

      return $list;
    }
    public static function getGenderById($id=NULL){
      $list=self::getGender();
      if($id!=NULL){
        return $list[$id];
      }
    }
    public static function getPtkpStatus($id=NULL){
      $list=[''=>'-Select-','tk0'=>'TK/0','tk1'=>'TK/1','tk2'=>'TK/2','tk3'=>'TK/3','k0'=>'K/0','k1'=>'K/1','k2'=>'K/2','k3'=>'K/3'];
      return $list;
    }
    public static function getEmploymentTaxStatus($id=NULL){
      $list=[1=>'Pegawai Tetap',2=>'Pegawai Tidak Tetap',3=>'Bukan Pegawai yang Bersifat Berkesinambungan'];
      return $list;
    }
    public static function getBankName($id=NULL){
      $list=[''=>'-SELECT BANK NAME-',1 => 'BCA',2 => 'Mandiri',3 => 'BRI'
            ,4 => 'CIMB',5 => 'Commonwealth',6 => 'BNI',7 => 'Danamon'
            ,8=> 'Panin',9=> 'Bank Permata',10 => 'BII',11=> 'BTN',12=> 'OCBC'
            ,13 => 'Mega',14 => 'UOB Indonesia',15=> 'Bank Sinarmas'
            ,16 => 'Bank Mayapada',17=> 'ANZ',18=> 'HCBC',19 => 'Hana Bank'
            ,20=> 'Bank DKI',21=> 'DBS Bank',22 => 'Bank Sumut',23=> 'Bank BJB'];

      return $list;
    }

    /**
     * [getMaritalStatus get marital status]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function getMaritalStatus($id=NULL){
      $list=[''=>'-Select-',1=>'Single',2=>'Married',3=>'Widow',4=>'Widower'];
      if($id!=NULL){
        return $list[$id];
      }
      return $list;
    }
    /**
     * [getBloodType get blood type]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function getBloodType($id=NULL){
      $list=[''=>'-Select-',1=>'A',2=>'B',3=>'O',4=>'AB'];
      return $list;
    }
    /**
     * [getIdentityType get identity type]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function getIdentityType($id=NULL){
      $list=[''=>'-Select-','ktp'=>'KTP','passport'=>'Passport'];
      return $list;
    }
    /**
     * [getReligion list religion]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function getReligion($id=NULL){
      $list=[''=>'-Select-',1=>'Islam',2=>'Christianity',3=>'Chatolic',4=>'Buddha'];
      if($id!=NULL){
        return $list[$id];
      }
      return $list;
    }
    /**
     * [getEmploymentStatus list employment status like fulltime,contract,probation]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function getEmploymentStatus($id=NULL){
      $list=[''=>'-Select-',1=>'Full Time',2=>'Contract',3=>'Probation'];
      if($id!=NULL){
        return $list[$id];
      }
      return $list;
    }
    /**
     * [getTaxConfig get Tax config]
     * @return [type] [description]
     */
    public static function getTaxConfig(){
      $list=['nett'=>'Netto','gross'=>'Gross'];
      return $list;
    }
    public static function getTypeSalary(){
      $list=['monthly'=>'Monthly','daily'=>'Daily'];
      return $list;
    }
    public static function getSalaryConfig(){
      $list=['taxable'=>'Taxable','non_taxable'=>'Non Taxable'];
      return $list;
    }
    public static function getDay(){
      $list=['monday'=>'Monday','tuesday'=>'Tuesday', 'wednesday'=>'Wednesday', 'thursday'=>"Thursday","friday"=>"Friday","saturday"=>"Saturday",'sunday'=>"Sunday"];
      return $list;
    }
    public static function getMonth(){
      $list=[1=>'January'
      ,2=>'Febuari'
      ,3=>'Maret'
      ,4=>'April'
      ,5=>'Mei'
      ,6=>'Juni'
      ,7=>'Juli'
      ,8=>'Agustus'
      ,9=>'September'
      ,10=>'Oktober'
      ,11=>'November'
      ,12=>'Desember'];
      return $list;
    }
    public static function getNameMonth($id){
      $list=self::getMonth();
      return $list[$id];
    }
    /**
     * [getYear description]
     * @return [type] [description]
     */
    public static function getYear(){
      $list=['2016'=>'2016','2017'=>'2017'];
      return $list;
    }
    //RESULT FORMAT:
   // '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'       =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
   // '%y Year %m Month %d Day'                                     =>  1 Year 3 Month 14 Days
   // '%m Month %d Day'                                             =>  3 Month 14 Day
   // '%d Day %h Hours'                                             =>  14 Day 11 Hours
   // '%d Day'                                                      =>  14 Days
   // '%h Hours %i Minute %s Seconds'                               =>  11 Hours 49 Minute 36 Seconds
   // '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
   // '%h Hours                                                     =>  11 Hours
   // '%a Days                                                      =>  468 Days
   public static function dateDifference($date_1 , $date_2 , $differenceFormat = '%y Year %m Month %d Day')
   {
       $datetime1 = date_create($date_1);
       $datetime2 = date_create($date_2);

       $interval = date_diff($datetime1, $datetime2);

       return $interval->format($differenceFormat);
   }



}
