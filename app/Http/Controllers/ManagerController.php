<?php

namespace App\Http\Controllers;

use App\Models\ManagerLeaves;
use App\Models\UserLeaves;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ManagerController extends Controller
{
    public function AddLeave(Request $request)
{
    $request->validate([
        // 'daterange' => 'required|string',
        'leavecategory' => 'required|string',
        'leavetype' => 'required|string',
        'cc' => 'array',
        'cc.*' => 'email',
        'reason' => 'required|string',
        'noofdays' => 'required|integer',
        'issandwich' => 'required|string',
        'user_id' => 'required|string',
        'fromdate'=>'required|string',
        'todate'=>'required|string'
    ]);

    $leave = new ManagerLeaves;
    $leave->leavecategory = $request->leavecategory;
    $leave->leavetype = $request->leavetype;
    $leave->issandwich = $request->issandwich;
    $leave->cc = json_encode($request->cc);
    $leave->fromdate = $request->fromdate;
    $leave->todate = $request->todate;
    $leave->noofdays = $request->noofdays;
    $leave->reason = $request->reason;
    $leave->user_id = $request->user_id;
    
    $data = $leave->save();
    $user = auth()->user();
    
    if ($data) {
        $email = Auth::user()->email;
        // $email1 = ['kartik@ycstech.in'];
        $messageData = [
            'username' => $user->name,
            'leavecategory' => $leave->leavecategory,
            'leavetype' => $leave->leavetype,
            'issandwich' => $leave->issandwich,
            'fromdate' => $leave->fromdate,
            'todate' => $leave->todate,
            'noofdays' => $leave->noofdays,
            'reason' => $leave->reason,
        ];

        Mail::send('emails.userLeave', $messageData, function ($message) use ($email, $leave) {
            $message->to($email)
                    ->subject('Leave Request')
                    ->cc(json_decode($leave->cc));
        });
        // Mail::send('emails.userLeave', $messageData, function ($message) use ($email1, $leave) {
        //     $message->to($email1)
        //             ->subject('Leave Request')
        //             ->cc(json_decode($leave->cc));
        // });

        return response()->json([
            'status' => 200,
            'message' => 'Data saved and email sent successfully',
        ]);
    } else {
        return response()->json([
            'status' => 400,
            'error' => 'Something went wrong',
        ]);
    }
}
    
        public function getManagerLeave()
        {
            $leave = ManagerLeaves::get();
            return response()->json($leave);
           
        }
    
    
    public function updateManagerLeave(Request $request, $id) {
      
        $leave = ManagerLeaves::findOrFail($id);
        $leave->leavecategory = $request->input('leavecategory');
        $leave->leavetype = $request->input('leavetype');
        $leave->fromdate = $request->input('fromdate');
        $leave->todate = $request->input('todate');
        $leave->noofdays = $request->input('noofdays');
        $leave->reason =  $request->input('reason');
        $data = $leave->save();
        
        $email = ['aniketnavale2712@gmail.com'];
        $messageData = [
            'leavecategory' => $request->leavecategory,
            'leavetype' => $request->leavetype,
            'fromdate' => $request->fromdate,
            'todate' => $request->todate,
            'noofdays' => $request->noofdays,
            'reason' => $request->reason,
            // 'data'=>$data
        ];
        // dd( $messageData);
    
     
        Mail::send('emails.updateUserLeave', $messageData, function ($message) use ($email) {
            $message->to($email)->subject('leave request');
        });
    
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Data updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'error' => 'Something went wrong',
            ]);
        }
    }
        public function deleteManagerLeave(Request $request, $id)
        {
            $leave = ManagerLeaves::find($id);
            if ($leave) {
                $leave->delete();
                return response()->json(['message' => 'Leave deleted successfully.'], 200);
            } else {
                return response()->json(['message' => 'Leave not found.'], 404);
            }
        }



       


}
