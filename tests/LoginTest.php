<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testClickLogin(){
    	$this->visit('/')
    		 ->click('login')
    		 ->seePageIs('/login');
    }

    public function testFormLogin(){
    	$this->visit('/login')
    		 ->see('Welcome to Talenta')
    		 ->dontSee('Welcome to Login')
    		 ->type('rendyjames01@gmail.com','email')
    		 ->type('Rendyjames123','password')
    		 ->press('btnLogin')
    		 ->seeJson(['url'=>route('dashboard')]);
    }

    public function testNewLogin()
    {
        // 1. if have email and password true
       $this->post('/login'
        , ['email' => 'rendyjames01@gmail.com'
          ,'password'=>'Rendyjames123'])
       ->seeJson(['status'=>'success','url'=>route('dashboard')]);
      
      // 2. if email empty
       $this->post('/login'
       , ['email' => ''
         ,'password'=>'testing123'])
      ->seeJson(['email'=>['The email field is required.']]);
      
      // 3. if password empty
      $this->post('/login'
       , ['email' => 'tesing@testing.com'
         ,'password'=>''])
      ->seeJson(['password'=>['The password field is required.']]);

      // 4. if email not format email
      $this->post('/login'
       , ['email' => 'tesing.com'
         ,'password'=>'testing'])
      ->seeJson(['The email must be a valid email address.']);

      //5. if password less than 6 character
      $this->post('/login'
      	, ['email' => 'testing@testing.com'
      	 ,'password'=>'test'])
      ->seeJson(['password'=>['The password must be at least 6 characters.']]);

      // 6. if email and password wrong
      $this->post('/login'
       , ['email' => 'tesing@testing.com'
         ,'password'=>'testing123'])
      ->seeJson(['Email or Password is wrong']);

      // 7. if all empty
      $this->post('/login'
       , ['email' => ''
         ,'password'=>''])
      ->seeJson(['email'=>['The email field is required.'],
      			 'password'=>['The password field is required.']]);
    }
}
