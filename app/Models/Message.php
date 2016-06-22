<?php

namespace App\Models;

use App\Models\CustomModel;

class Message extends CustomModel
{

    // public $timestamps=false;

  protected $rules=array(
    'receiver_id_fk' => 'required',
    'subject'=>'required|max:255',
    'message'=>'required');
  protected $attributeNames=[
    'receiver_id_fk'=>'Recipient',
    'subject'=>'Subject',
    'message'=>'Message'
  ];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['subject','message','attachment'];

  // protected $guarded = ['is_read','box_type','created_at','updated_at','deleted_at_sender','deleted_at_receiver'];

    /**
     * get relationship with sender user
     * @return object user
     */
    public function sender(){
      return $this->belongsTo('App\Models\User','sender_id_fk');
    }
    public function senderName(){
      return $this->belongsTo('App\Models\User','sender_id_fk')->select('name');
    }

    /**
     * get relationship with receiver user
     * @return object user
     */
    public function receiver(){
      return $this->belongsTo('App\Models\User','receiver_id_fk');
    }
    public function receiverName(){
      return $this->belongsTo('App\Models\User','receiver_id_fk')->select('name');
    }
}
