<?php

namespace App\Http\Controllers;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Response;
use Sentinel;
use Mail;
use App\Models\User;
use App\Models\Company;
use App\Models\Message;
use Config;
use Carbon\Carbon;
use Validator;
use Constant;
use App\Models\TimeOffRequest;
use App\Models\Approvement;
use App\Models\ReimbursementRequest;
class MessageController extends Controller
{


   /**
    * Create a new authentication controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role');
    }


    /**
     * Fungsi untuk mengambil list message yang ada
     * @param int boxType = tipe box surat (inbox, reimbursement, overtime, time-off, dsb)
     * @param string searchKey = untuk searching, filter by subject
     * @return json(list of messages)
     */
    protected function loadMessages ($boxType, $searchKey = ''){
        DB::enableQueryLog();
        $userid = Sentinel::getUser()->id;
        $deleted_at = 'deleted_at_receiver';
        if ($boxType == '1' ) { //INBOX
            $messages = Message::with(['sender' => function($query) {
                            $query->addSelect(['name','id']);
                        }])
                        ->where(function($q) use ($searchKey) {
                            $q->where('subject', 'like', "%$searchKey%");
                            $q->orWhere('message', 'like', "%$searchKey%");
                            $q->orWhereHas('sender', function($query) use ($searchKey) {
                                $query->where('name', 'like', "%$searchKey%");
                            });
                        })
                        ->where('receiver_id_fk',$userid)
                        ->where($deleted_at, null )
                        ->orderBy('created_at', 'desc')
                        ->get(['id','created_at','is_read','subject','sender_id_fk']);
        } else if ($boxType == '0' ) { //SENT ITEM
            $deleted_at = 'deleted_at_sender';
            $messages = Message::with(['receiver' => function($query) {
                            $query->addSelect(['name','id']);
                        }])
                        ->where(function($q) use ($searchKey) {
                            $q->where('subject', 'like', "%$searchKey%");
                            $q->orWhere('message', 'like', "%$searchKey%");
                            $q->orWhereHas('receiver', function($query) use ($searchKey) {
                                $query->where('name', 'like', "%$searchKey%");
                            });
                        })
                        ->where('sender_id_fk',$userid)
                        ->where('box_type','1') // cuma ambil sent message biasa (box_type=1)
                        ->where($deleted_at, null )
                        ->orderBy('created_at', 'desc')
                        ->get(['id','created_at','is_read','subject','receiver_id_fk']);
        } else if ($boxType == '2' ) { //TIMEOFF
          $messages = Message::with(['sender' => function($query) {
                          $query->addSelect(['name','id']);
                      }])
                      ->where(function($q) use ($searchKey) {
                          $q->where('subject', 'like', "%$searchKey%");
                          $q->orWhere('message', 'like', "%$searchKey%");
                          $q->orWhereHas('sender', function($query) use ($searchKey) {
                              $query->where('name', 'like', "%$searchKey%");
                          });
                      })
                      ->where('receiver_id_fk',$userid)
                      ->where('box_type',$boxType)
                      ->where($deleted_at, null )
                      ->orderBy('created_at', 'desc')
                      ->get(['id','created_at','is_read','subject','sender_id_fk']);//->toArray();
        } else if ($boxType == '3' ) { //REIMBURSEMENT
          $messages = Message::with(['sender' => function($query) {
                          $query->addSelect(['name','id']);
                      }])
                      ->where(function($q) use ($searchKey) {
                          $q->where('subject', 'like', "%$searchKey%");
                          $q->orWhere('message', 'like', "%$searchKey%");
                          $q->orWhereHas('sender', function($query) use ($searchKey) {
                              $query->where('name', 'like', "%$searchKey%");
                          });
                      })
                      ->where('receiver_id_fk',$userid)
                      ->where('box_type',$boxType)
                      ->where($deleted_at, null )
                      ->orderBy('created_at', 'desc')
                      ->get(['id','created_at','is_read','subject','sender_id_fk']);//->toArray();
        }
        return Response::json($messages);
    }

    /**
     * Membuka dan membaca 1 pesan yang di-klik
     * @param   int boxType = tipe box surat (inbox, reimbursement, overtime, time-off, dsb)
     * @param   int messageID = id pesan yang akan dibuka
     * @param   boolean markAsRead = fungsi ini sekaligus menandai bahwa pesan telah dibaca.
     *          (markAsRead=false saat membuka "Sent Item")
     * @return  json(detil pesan)
     */
    protected function readMessage ($messageID, $isInbox=true, $checkValidation=false){
      $message='query failed'; //default return message

      if($isInbox == "true"){ //"INBOX"
        $message = Message::with(['sender' => function($query) {
                        $query->addSelect(['name','id']);
                    }])
                    ->where('id', $messageID)
                    ->where('deleted_at_receiver',null)
                    ->first(['fk_ref','created_at','id','subject','message','sender_id_fk','receiver_id_fk','box_type'])
                    ->toArray();

        $userID = Sentinel::getUser()->id;
        if ($checkValidation){ //prevent unathorized user from opening another user's message
            $receiverID = $message['receiver_id_fk'];
            if($receiverID != $userID) return 'invalid'; // receiver_id doesnt match with logged-in user_id
        }

        $message['sender']['avatar'] = User::find($message['sender_id_fk'])->userAccessConnection->getAvatar();
        $boxType = $message['box_type'];

        if( $message['fk_ref'] != 0 ){ // kalo dia punya ref ke tabel request (berarti ini message approval)
            $message['approvement']=Approvement::where('fk_ref',$message['fk_ref'])->where('box_type',$boxType)
                                              ->where('approved_by',$userID)->first();
            if ($boxType==2) {
              $message['fk_ref']=TimeOffRequest::with(['policy'])->where('id',$message['fk_ref'])->first();
              $message['fk_ref']['start_date'] = date('D, F jS', strtotime($message['fk_ref']['start_date']));
              $message['fk_ref']['end_date']   = date('D, F jS', strtotime($message['fk_ref']['end_date']));
            }
            else if ($boxType==3) {
              // $message['approvement']=Approvement::where('fk_ref',$message['fk_ref'])->where('box_type',$boxType)
              //                                    ->where('approved_by',$userID)->first();
              $reimbursement = ReimbursementRequest::with(['policy'])->where('id',$message['fk_ref'])->first();
              $reimbursement->getAttachment();
              $message['fk_ref']=$reimbursement;
            }
        }
        // mark as read
        Message::where('id', $messageID)->update(['is_read' => 1]);

      } else { //"SENT ITEM"
        $message = Message::with(['receiver' => function($query) {
                        $query->addSelect(['name','id']);
                    }])
                    ->where('id', $messageID)
                    ->where('deleted_at_sender',null)
                    ->first(['created_at','id','subject','message','receiver_id_fk']);
        $message['receiver']['avatar'] = User::find($message['receiver_id_fk'])->userAccessConnection->getAvatar();
      }
      return Response::json($message);
    }

    /**
     * Soft-delete pesan (atau beberapa pesan)
     * @param Request $request, berisi list id pesan yang akan dihapus
     * @return 1 (success)
     */
    protected function deleteMessage (Request $request, $isInbox){
        if ($isInbox==1) $where = 'deleted_at_receiver';
        else             $where = 'deleted_at_sender';
        date_default_timezone_set('Asia/Jakarta');
        $result = Message::whereIn('id', $request['list'])
                ->update([$where => Carbon::now()]);
        return $result;
    }

    /**Controller
     * Fungsi untuk mengirim notifikasi 'New Message' ke e-mail penerima
     * @param  Request  $request
     * @param  int  $sender_id
     * @param  int  $receiver_id (atau recipient_id)
     * @return int  $success
     */
    public function sendEmailNotification(Request $request ,$messageID, $receiver_id,$emailView,$subject,$var)
    {
        $sender = Sentinel::getUser()->name;
        $success = 1;
        $receiver = User::findOrFail($receiver_id);

        // create string hash set on email
        $IDlength = strlen( (string) $messageID);
        $stringRandom = str_random(31-$IDlength) . $messageID . $IDlength;

        $position=mt_rand(0,32);
        $firstString=substr($stringRandom,0,$position);
        $secondString=substr($stringRandom,$position);
        $positionLength=strlen($position);  //value: 1-2
        $LengthId=strlen($receiver->id);    //value: 1-9
        $hashString=$firstString.$receiver->id.$secondString.$position.$positionLength.$LengthId;

        $success = $hashString;
        Mail::send('emails.'.$emailView,['receiver'=>$receiver->name,'sender'=>$sender,'var'=>$var,'code'=>$hashString], function ($m) use ($receiver, $subject) {
                $m->from('no-reply@talenta.co');
                $m->to($receiver->email, $receiver->name)->subject($subject);
        });

        if(count(Mail::failures()) > 0){
            $errors = 'Failed to send message notification email, please try again.';
            print_r($errors);
            $success = 0;
        }
        return $success;
    }

    /** ReadMessageFromEmail fungsinya ada di Auth\AuthController */

    /**
     * mengirim pesan ke karyawan lain, sekaligus kirim notifikasi ke e-mail
     * @param Request $request, berisi data pesan dan list data penerima
     * @return json('success')
     */
    protected function sendMessage (Request $request, $boxType = '1',$emailView='newmessage',$subject='You have a new message!',$var=''){
        $validator = Validator::make($request->all(), [
            'receiver_id_fk' => 'required',
            'subject'=>'required|max:255',
            'message'=>'required',
        ]);
        $validator->setAttributeNames((new Message)->getAttributeNames());

        if ($validator->fails()) {
            return response()->json($validator->messages());
        } else {
         	for ($i=0; $i<count($request->receiver_id_fk);$i++){
                $insert = new Message;
                $insert->subject = $request->subject;
                $insert->message = $request->message;
                $insert->sender_id_fk = Sentinel::getUser()->id;
                $insert->receiver_id_fk = $request->receiver_id_fk[$i];
                // 'attachment'  => '', //attachment,
                $insert->box_type = $boxType; //box_type default=1 for normal inbox and sent item
                $insert->is_read = '0';
                $insert->save();
                $this->sendEmailNotification($request, $insert->id, $request->receiver_id_fk[$i],$emailView,$subject,$var);
    	    }
            return response()->json(['status'=>'success']);
        }
    }

    /**
     * retrieve list of messsage recipients in the same company as user's
     * @return json(list of recipients)
     */
    protected function getRecipient (){
        $id = Sentinel::getUser()->id;
        $company_id_fk = Sentinel::getUser()->company_id_fk;
        $recipients = User::where('company_id_fk',$company_id_fk)
                          ->where('id','!=',$id)
                          ->get(['id', 'name']);
        foreach($recipients as $recipient){
          //get job
          $recipient->job = '';
          $employee = $recipient->userAccessConnection->userEmployee;
          if($employee){
            $pos = $employee->employeeJobPosition;
            if($pos){
              $recipient->job = $pos->name;
            }
          }
          //getAvatar return user's avatar or blank.jpg
          $recipient->avatar=$recipient->userAccessConnection->getAvatar();

          //unset $recipient->userAccess, so user access data will not be send to the front
          unset($recipient->userAccessConnection);
        }
        return Response::json($recipients);
    }

    /**
     *  Menghitung jumlah notifikasi pesan yang belum dibaca
     *  @return json(jumlah pesan baru)
     */
    protected function countEachUnreadMessage (){
        $id = Sentinel::getUser()->id;

        // $count = Message::where('is_read', '0')
        //                 ->where('receiver_id_fk', $id)
        //                 ->where('deleted_at_receiver', null)
        //                 ->where('box_type','1')
        //                 ->count();

        $count =  DB::table('messages') //count(case when box_type = '0' then 1 else null end) AS '0',
                    ->select( DB::raw ("count(case when box_type = '1' then 1 else null end) as '1',
                                        count(case when box_type = '2' then 1 else null end) as '2',
                                        count(case when box_type = '3' then 1 else null end) as '3'"))
                                        // count(case when box_type = '4' then 1 else null end) as '4',
                                        // count(case when box_type = '5' then 1 else null end) as '5',
                                        // count(case when box_type = '6' then 1 else null end) as '6',
                                        // count(case when box_type = '7' then 1 else null end) as '7',
                                        // count(case when box_type = '8' then 1 else null end) as '8',
                                        // count(case when box_type = '9' then 1 else null end) as '9'"))
                    ->where('is_read', '0')
                    ->where('receiver_id_fk', $id)
                    ->where('deleted_at_receiver', null)
                    ->first();

        return Response::json($count);
    }

    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($trigger='none') {
        return view('message/list')->with('triggerOpen', $trigger);
    }

    public static function createCustomMessage(array $data){
      // loop for each approvers
      foreach($data['receivers'] as $datum){
        $model= new Message();
        $model->subject= $data['subject'];
        $model->box_type=$data['type'];
        $model->message=$data['reason'];
        $model->fk_ref=$data['fk_ref'];
        $model->sender_id_fk=Sentinel::getUser()->id;
        $model->receiver_id_fk=$datum['id'];
        $model->save();
      }
    }

    public function doReject(Request $request){
      // check apakah dia masih bisa approve
      // kondisi dia tidak bisa approve: kalo request tersebut sudah pernah di-reject approver lain
      // if(ApprovementController::isApprovementDisabled()) {
      //   return Response::json(['status'=>'disabled']);
      // }
      $id = $request->input('id');
      $data['reason'] = $request->input('reason');
      $data['msg_model'] = Message::find($id);
      $app = ApprovementController::rejectRequest($data);
      if ($app) return Response::json(['status'=>'rejected']);
      else return response()->json(['status'=>'unauthorized']);
    }

    public function doApprove(Request $request){
      // check apakah dia masih bisa approve
      // kondisi dia tidak bisa approve: kalo request tersebut sudah pernah di-reject approver lain
      // if(ApprovementController::isApprovementDisabled()) {
      //   return Response::json(['status'=>'disabled']);
      // }
      $id = $request->input('id');
      $data['reason']=$request->input('reason');
      $data['msg_model'] = Message::find($id);
      $app = ApprovementController::approveRequest($data);
      if ($app) return Response::json(['status'=>'approved']);
      else return response()->json(['status'=>'unauthorized']);
    }
}
