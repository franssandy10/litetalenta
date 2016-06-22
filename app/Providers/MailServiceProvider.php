<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Mail;
use App\Models\AccessToken;
use Constant;
use URL;
use Config;
class MailServiceProvider extends ServiceProvider
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
    /**
     * Send an e-mail for testing.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public static function mailTesting()
    {
      $data=[];
      URL::forceRootUrl(Config::get('app.url'));
      Mail::send('emails.welcome', $data, function ($message) {
        $message->from('no-reply@bridgeinc.co', 'Laravel');

        $message->to('valdmir@litmustest.com');
      });
        // Mail::send('emails.welcome', ['user' => $user], function ($m) use ($user) {
        //     $m->from('no-repy@bridgeinc.co', 'Your Application');
        //
        //     $m->to('valdmir@litmustest.com')->subject('Your Reminder!');
        // });
    }
    public static function emailWithCode($data){
      URL::forceRootUrl(Config::get('app.url'));
      if(isset($data['admin'])==false) $data['admin']='';
      Mail::send($data['template_name'],['user'=>$data['user'],'admin'=>$data['admin'],'code'=>$data['code']], function ($message) use ($data) {
          $message->from('no-reply@talenta.co');
          $message->to($data['user']['email'], $data['user']['name'])->subject($data['subject']);
      });
    }
    public static function emailRequestWithCode($data,$var=''){ // TODO ga selalu harus ambil ess_array ( untuk send approval result to employee )
      foreach($data['receivers'] as $receiver){
        $data['code']=(new AccessToken())->generateToken($receiver['id'],$data['fk_ref'],$data['type'],1);
        $ess_array = json_decode($receiver->ess_email,true);
        $arr = array(
            'name'=>$data['sender_name']
            ,'receiver'=>$receiver->name
            ,'code'=>$data['code']
            ,'datedesc'=>$data['datedesc']
            ,'var'=>$var
            ,'reason'=>$data['reason']);

        if ($data['ess_type']) $arr['ess_email_setting'] = $ess_array[$data['ess_type']];
        Mail::queue( $data['template_name'], $arr, function ($message) use ($data,$receiver) {
                $message->from('no-reply@talenta.co');
                $message->to($receiver['email'], $receiver['name'])->subject($data['subject']);
            }
        );
      }
    }
    /**
     * Send an e-mail  to the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function mailForgotPassword()
    {
        // $user = User::findOrFail($id);
        //
        // Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
        //     $m->from('hello@app.com', 'Your Application');
        //
        //     $m->to($user->email, $user->name)->subject('Your Reminder!');
        // });
    }
}
