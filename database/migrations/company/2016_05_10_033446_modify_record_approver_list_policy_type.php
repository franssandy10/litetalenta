<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ApproverList;

class ModifyRecordApproverListPolicyType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {print_r('expression');
        // prior to this migration, policy_type in approver_lists work as:
        // 1: for time-off type
        // 2: for reimbursement type
        //
        // from now on we will change that to:
        // 2: for time-off type
        // 3: for reimbursement type

        // Get old records
        $results = DB::table('approver_lists')->get();
        // $results = ApproverList(false,2)::all();
        // $results = ApproverList::all();
// print_r('blabllalbala'); 
// print_r($results); 
        // Loop through the results
        foreach($results as $result)
        {
            // change type
            if      ($result->policy_type == 1) $policy_type=2;
            else if ($result->policy_type == 2) $policy_type=3;

            // update the new value.
            DB::table('approver_lists')
                    ->where('id', $result->id)
                    ->update(['policy_type' => $policy_type]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // $results = DB::table('approver_lists')->get();
        // foreach($results as $result)
        // {
        //     if      ($result->policy_type == 3) $policy_type=2;
        //     else if ($result->policy_type == 2) $policy_type=1;
        //     DB::table('approver_lists')
        //             ->where('id', $result->id)
        //             ->update(['policy_type' => $policy_type]);
        // }
    }
}
