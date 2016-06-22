<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetStartedOne()
    {
      // 1. if true
      $this->post('/get-started-1'
       , ['name' => 'Nadia Syarifa'
        ,'company_name'=>'Dorayaki'
        ,'email'=>'nadiasyarifa10@gmail.com'
        ,'phone'=>'0821200776611'
        ,'password'=>'Nadiasayang10'
        ,'password_confirmation'=>'Nadiasayang10'])
      ->seeJson(['status'=>'success','url'=>'http://locahost:8000/get-started-2']);
      // 2. name kosong
      // if using app/http/requests/customrequest
      $this->post('/get-started-1'
       , ['name' => ''
        ,'company_name'=>'Indovaping'
        ,'email'=>'frans.purple@gmail.com'
        ,'phone'=>''
        ,'password'=>'Indovaping10'
        ,'password_confirmation'=>'Indovaping10'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['name'=>['The full name field is required.']])->assertResponseStatus(422);
      // 3. name only 1 words
      $this->post('/get-started-1'
       , ['name' => 'frans'
        ,'company_name'=>'Indovaping'
        ,'email'=>'frans.purple@gmail.com'
        ,'phone'=>''
        ,'password'=>'Indovaping10'
        ,'password_confirmation'=>'Indovaping10'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['name'=>['The full name must contain minimum 2 words and spaces.']])->assertResponseStatus(422);
      //4. Company name kosong
      $this->post('/get-started-1'
       , ['name' => 'frans testing'
        ,'company_name'=>''
        ,'email'=>'frans.purple@gmail.com'
        ,'phone'=>''
        ,'password'=>'Indovaping10'
        ,'password_confirmation'=>'Indovaping10'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['company_name'=>['The company name field is required.']])->assertResponseStatus(422);
      //5. email kosong
      $this->post('/get-started-1'
       , ['name' => 'frans testing'
        ,'company_name'=>'Indovaping'
        ,'email'=>''
        ,'phone'=>''
        ,'password'=>'Indovaping10'
        ,'password_confirmation'=>'Indovaping10'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['email'=>['The email field is required.']])->assertResponseStatus(422);
      //6. email tidak valid.
      $this->post('/get-started-1'
       , ['name' => 'frans testing'
        ,'company_name'=>'Indovaping'
        ,'email'=>'gmail.com'
        ,'phone'=>''
        ,'password'=>'Indovaping10'
        ,'password_confirmation'=>'Indovaping10'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['email'=>['The email must be a valid email address.']])->assertResponseStatus(422);
      //7. Email sudah terdaftar.
      // $this->post('/get-started-1'
      //  , ['name' => 'frans testing'
      //   ,'company_name'=>'Indovaping'
      //   ,'email'=>'frans.purple@gmail.com'
      //   ,'phone'=>'081200998811'
      //   ,'password'=>'Indovaping10'
      //   ,'password_confirmation'=>'Indovaping10'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      // ->seeJson(['email'=>['The email has already been taken.']])->assertResponseStatus(422);
      //8. No tlp harus antara 6 dan 20 digit. 
      $this->post('/get-started-1'
       , ['name' => 'frans testing'
        ,'company_name'=>'Indovaping'
        ,'email'=>'frans.purple@gmail.com'
        ,'phone'=>'0812'
        ,'password'=>'Indovaping10'
        ,'password_confirmation'=>'Indovaping10'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['phone'=>['The phone must be between 6 and 20 digits.']])->assertResponseStatus(422);
      //9. 
      // $this->post('/get-started-1'     
      //  , ['name' => 'frans testing'
      //   ,'company_name'=>'Indovaping'
      //   ,'email'=>'frans.purple@gmail.com'
      //   ,'phone'=>'6591224'
      //   ,'password'=>'testing123'
      //   ,'password_confirmation'=>'Testing123'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      // ->seeJson([''=>['The phone must be between 6 and 20 digits.']])->assertResponseStatus(422);
      // $this->post('/get-started-1'
      //  , ['name' => 'Testing Testing'
      //   ,'company_name'=>'Testing'
      //   ,'email'=>'testing@testing.com'
      //   ,'phone'=>'6519'
      //   ,'password'=>'testing'
      //   ,'password_confirmation'=>''],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      // ->seeJson(['phone'=>['The phone must be between 6 and 20 digits']])->assertResponseStatus(422);
    }
}
