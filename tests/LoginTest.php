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
        // if all empty
      $this->post('/login'
       , ['email' => ''
         ,'password'=>''])
      ->seeJson(['email'=>['The email field is required.'],'password'=>['The password field is required.']]);
      // 1. if email empty
      $this->post('/login'
       , ['email' => 'tesing@testing.com'
         ,'password'=>''])
      ->seeJson(['password'=>['The password field is required.']]);
      // 2. if password empty
      $this->post('/login'
       , ['email' => ''
         ,'password'=>'testing123'])
      ->seeJson(['email'=>['The email field is required.']]);
      // 3. if email not format email
      $this->post('/login'
       , ['email' => 'tesing.com'
         ,'password'=>'testing'])
      ->seeJson(['The email must be a valid email address.']);
      // 3. if email and password wrong
      $this->post('/login'
       , ['email' => 'tesing@testing.com'
         ,'password'=>'testing'])
      ->seeJson(['Email or Password is wrong']);
      // 4. if have email and password true
       $this->post('/login'
        , ['email' => 'rendyjames01@gmail.com'
          ,'password'=>'Rendyjames123'])
       ->seeJson(['status'=>'success','url'=>route('dashboard')]);
    }
}
