<?php

namespace App\Providers;
use Sentinel;
use Illuminate\Support\ServiceProvider;
use App\Models\Message;
class MessageServiceProvider extends ServiceProvider
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
     *  Counting ALL unread messages
     *  used in every page, at navbar section
     *  @return int count_result;
     */
    public static function countAllUnreadMessage(){
      $count = Message::where('is_read', '0')
                      ->where('receiver_id_fk', Sentinel::getUser()->id)
                      ->where('deleted_at_receiver', null)
                      ->count();
      return $count;
    }
}
