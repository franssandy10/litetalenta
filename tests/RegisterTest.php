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
    //Definition Link Page
    public function testClickRegister(){
      $this->visit('/')
           ->click('Register')
           ->seePageIs('/get-started-1');
    }
    //Definition form
    public function testFormGetStartedOne(){
      $this->visit('/get-started-1')
           ->see('Basic Profile')
           ->dontSee('Register')
           ->type('Honey Sugar','name')
           ->type('Sejahtera', 'company_name')
           ->type('honey.sugar@gmail.com','email')
           ->type('02199008811','phone')
           ->type('honeysugar123','password')
           ->type('honeysugar123','password_confirmation')
           ->press('submitButton');         
    }
    //Fill the form
    public function testGetStartedOne(){
      // 1. if true
      $this->post('/get-started-1'
       , ['name' => 'Nadia Syarifa'
        ,'company_name'=>'Dorayaki'
        ,'email'=>'nadiasyarifa10@gmail.com'
        ,'phone'=>'0821200776611'
        ,'password'=>'Nadiasayang10'
        ,'password_confirmation'=>'Nadiasayang10'])
      ->seeJson(['status'=>'success','url'=>route('getstarted.two')]);
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
      $this->post('/get-started-1'
       , ['name' => 'frans testing'
        ,'company_name'=>'Indovaping'
        ,'email'=>'frans.purple@gmail.com'
        ,'phone'=>'081200998811'
        ,'password'=>'Indovaping10'
        ,'password_confirmation'=>'Indovaping10'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['email'=>['The email has already been taken.']])->assertResponseStatus(422);
      //8. No tlp harus antara 6 dan 20 digit. 
      $this->post('/get-started-1'
       , ['name' => 'frans testing'
        ,'company_name'=>'Indovaping'
        ,'email'=>'frans.purple@gmail.com'
        ,'phone'=>'0812'
        ,'password'=>'Indovaping10'
        ,'password_confirmation'=>'Indovaping10'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['phone'=>['The phone must be between 6 and 20 digits.']])->assertResponseStatus(422);
      //9. password kosong 
      $this->post('/get-started-1'     
        ,['name' => 'frans testing'
        ,'company_name'=>'Indovaping'
        ,'email'=>'testing@testing.com'
        ,'phone'=>'081299880011'
        ,'password'=>''
        ,'password_confirmation'=>'Testin123'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['password'=>['The password field is required.']])->assertResponseStatus(422);
      //10. Password kurang dari 6 character
      $this->post('/get-started-1'
       , ['name' => 'Testing Testing'
        ,'company_name'=>'Testing'
        ,'email'=>'testing@testing.com'
        ,'phone'=>'02199001122'
        ,'password'=>'Test2'
        ,'password_confirmation'=>'Testing123'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['password'=>['The password must be at least 6 characters.','The password confirmation does not match.']])
      ->assertResponseStatus(422);
      //11. Not Contain number
      $this->post('/get-started-1'
       , ['name' => 'Testing Testing'
        ,'company_name'=>'Testing'
        ,'email'=>'testing@testing.com'
        ,'phone'=>'02199001122'
        ,'password'=>'Testing'
        ,'password_confirmation'=>'Testing'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['password'=>['The password must contain number,uppercase,lowercase']])
      ->assertResponseStatus(422);
      //12. Not Contain lowercase
      $this->post('/get-started-1'
       , ['name' => 'Testing Testing'
        ,'company_name'=>'Testing'
        ,'email'=>'testing@testing.com'
        ,'phone'=>'02199001122'
        ,'password'=>'TESTING1'
        ,'password_confirmation'=>'TESTING1'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['password'=>['The password must contain number,uppercase,lowercase']])
      ->assertResponseStatus(422);
       //13. Not Contain UPPERCASE
      $this->post('/get-started-1'
       , ['name' => 'Testing Testing'
        ,'company_name'=>'Testing'
        ,'email'=>'testing@testing.com'
        ,'phone'=>'02199001122'
        ,'password'=>'testing1'
        ,'password_confirmation'=>'testing1'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
      ->seeJson(['password'=>['The password must contain number,uppercase,lowercase']])
      ->assertResponseStatus(422);
}

/*----------------------------------------------------------------------------------------------------------------------*/

      //Definition Form
      public function testFormGetStartedTwo(){
       $this->visit('/get-started-2')
           ->see('Time Off Setting')
           ->dontSee('Register')
           ->type('10','holiday')
           ->type('5', 'sick')
           ->press('submitButton');           
      }
      //test button preview
      public function testClickPrevForm2(){
        $this->visit('/get-started-2')
             ->click('prev')
             ->seePageIs('/get-started-1');
           }
   
      //Fill the form
      public function testGetStartedTwo(){
      $this->post('/get-started-2'
      ,['holiday' => '12'
      , 'sick'=>'6'])
      ->seeJson(['status'=>'success','url'=>route('getstarted.three')]);
      
      //Holiday and sick kosong
      $this->post('/get-started-2'
      ,['holiday' => ''
      , 'sick'=>''])
      ->seeJson(['status'=>'success','url'=>route('getstarted.three')]);

      //Holiday kosong
      $this->post('/get-started-2'
      ,['holiday' =>''
      , 'sick' => '6'])
      ->seeJson(['status'=>'success','url'=>route('getstarted.three')]);

      //Sick kosong
      $this->post('/get-started-2'
      ,['holiday' =>'12'
      , 'sick' => ''])
      ->seeJson(['status'=>'success','url'=>route('getstarted.three')]);
      }

/*----------------------------------------------------------------------------------------------------------------------*/        
      //Definition Form
      public function testFormGetStartedThree(){
        $this->visit('/get-started-3')
             ->see('Payroll Feature')
             ->dontSee('Register')
             ->select('yes','payroll_flag')
             ->select('no','payroll_flag')
             ->press('submitButton');
      }

      //test button preview
      public function testClickPrevForm3(){
        $this->visit('/get-started-3')
             ->click('prev')
             ->seePageIs('/get-started-2');
      }

      //Pilih Payroll Flag Yes
      public function testPayrollFlagYes(){
        $this->post('/get-started-3'
        , ['payroll_flag' => 'yes'])
        ->seeJson(['url' => route('getstarted.four')]);
      }

      //Pilih Payroll Flag No
      public function testPayrollFlagNo(){
        $this->post('/get-started-3'
        , ['payroll_flag' => 'No'])
        ->seeJson(['url' => route('getstarted.four')]);
      }

/*---------------------------------------------------------------------------------------------------------------------*/

      //Definition Form
      public function testFormGetStartedFour(){
      $this->visit('/get-started-4')
           ->see('Configure Payroll')
           ->dontSee('Attendance')
           ->type('Merry Jane', 'tax_person_name')
           ->type('984923743242398', 'tax_person_npwp')
           ->type('2394327492394','company_npwp')
           ->type('28 June, 2016','npwp_date')
           ->type('4687236473264732782','company_bpjstk')
           ->select('1','company_jkk')
           ->select('2','company_jkk')
           ->select('3','company_jkk')
           ->select('4','company_jkk')
           ->select('5','company_jkk')
           ->press('submitButton');   
            }

      //test button preview
      public function testClickPrevForm4(){
        $this->visit('/get-started-4')
             ->click('prev')
             ->seePageIs('/get-started-3');
      }

      // Configure Payroll True
      public function testConfigurePayrollTrue(){
        $this->post('/get-started-4'
        ,['tax_person_name' => 'Franko'
        , 'tax_person_npwp' => '87.646.237.6-327.462'
        , 'company_npwp' => '38.242.363.7-246.232'
        , 'npwp_date' => '2016-06-30'
        , 'company_bpjstk' => '293843282289387'
        , 'company_jkk' => '1'])
        ->seeJson(['status'=>'success','url'=>route('register')]);

      // Tax person name kosong
      $this->post('/get-started-4'
        ,['tax_person_name' => ''
        , 'tax_person_npwp' => '87.646.237.6-327.462'
        , 'company_npwp' => '38.242.363.7-246.232'
        , 'npwp_date' => '2016-06-30'
        , 'company_bpjstk' => '293843282289387'
        , 'company_jkk' => '1'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
        ->seeJson(['tax_person_name'=>['The Tax Person Name field is required.']])
        ->assertResponseStatus(422);

      // Tax Person NPWP kosong
      $this->post('/get-started-4'
        ,['tax_person_name' => 'Monalisa'
        , 'tax_person_npwp' => ''
        , 'company_npwp' => '38.242.363.7-246.232'
        , 'npwp_date' => '2016-06-30'
        , 'company_bpjstk' => '293843282289387'
        , 'company_jkk' => '1'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
        ->seeJson(['tax_person_npwp'=>['The Tax Person NPWP Number field is required.']])  
        ->assertResponseStatus(422);

      // Tax Company NPWP kosong
      $this->post('/get-started-4'
        ,['tax_person_name' => 'Janeco'
        , 'tax_person_npwp' => '23.908.786.4-234.678'
        , 'company_npwp' => ''
        , 'npwp_date' => '2016-06-30'
        , 'company_bpjstk' => '293843282289387'
        , 'company_jkk' => '1'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
        ->seeJson(['company_npwp'=>['The Company NPWP Number field is required.']])  
        ->assertResponseStatus(422);

        // NPWP Date kosong
        $this->post('/get-started-4'
        ,['tax_person_name' => 'Janeco'
        , 'tax_person_npwp' => '23.908.786.4-234.678'
        , 'company_npwp' => '22.345.234.5-435.543'
        , 'npwp_date' => ''
        , 'company_bpjstk' => '293843282289387'
        , 'company_jkk' => '1'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
        ->seeJson(['npwp_date'=>['The NPWP Date field is required.']])  
        ->assertResponseStatus(422);

        // BPJSTK kosong
        $this->post('/get-started-4'
        ,['tax_person_name' => 'Janeco'
        , 'tax_person_npwp' => '23.908.786.4-234.678'
        , 'company_npwp' => '22.345.234.5-435.543'
        , 'npwp_date' => '2016-05-10'
        , 'company_bpjstk' => ''
        , 'company_jkk' => '1'],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
        ->seeJson(['company_bpjstk'=>['The BPJSTK Number field is required.']])  
        ->assertResponseStatus(422);

        //Company JKK Kosong
        $this->post('/get-started-4'
        ,['tax_person_name' => 'Janeco'
        , 'tax_person_npwp' => '23.908.786.4-234.678'
        , 'company_npwp' => '22.345.234.5-435.543'
        , 'npwp_date' => '2016-05-10'
        , 'company_bpjstk' => '234867237642783827'
        , 'company_jkk' => ''],['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'])
        ->seeJson(['company_jkk'=>['The JKK Type field is required.']])  
        ->assertResponseStatus(422);
      }

}
