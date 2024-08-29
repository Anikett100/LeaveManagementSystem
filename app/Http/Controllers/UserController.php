<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserLeaves;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Log;
use Validator;

class UserController extends Controller
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

  
    $leave = new UserLeaves;
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

    public function getLeave()
    {
        $userId = auth()->id(); 
    $leave = UserLeaves::where('user_id', $userId)->orderBy('id', 'desc')->get();

        return response()->json($leave);
    }

    public function getLeaves()
{
    $userId = auth()->id(); 
    $leave = UserLeaves::where('user_id', $userId)->orderBy('id', 'desc')->get();

    return response()->json(['leaves' => $leave]);
}


// for update
    public function getUserLeave($id)
{
    $leave = UserLeaves::find($id);

    if (!$leave) {
        return response()->json(['error' => 'Leave not found'], 404);
    }

    return response()->json($leave);
}


public function updateLeave(Request $request)
{
    $validator = Validator::make($request->all(), [
        'fromdate' => 'required|date',
        'todate' => 'required|date',
        'leavecategory' => 'required|string',
        'leavetype' => 'required|string',
        'cc' => 'array',
        'cc.*' => 'email',
        'reason' => 'required|string',
        'noofdays' => 'required|integer',
        'issandwich' => 'required|string',
        'user_id' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $leave = UserLeaves::find($request->id);

    if (!$leave) {
        return response()->json(['error' => 'Leave record not found'], 404);
    }

    $leave->leavetype = $request->leavetype;
    $leave->leavecategory = $request->leavecategory;
    $leave->cc = json_encode($request->cc);
    $leave->reason = $request->reason;
    $leave->fromdate = $request->fromdate;
    $leave->todate = $request->todate;
    $leave->noofdays = $request->noofdays;
    $leave->issandwich = $request->issandwich;
    $leave->save();

    $email = Auth::user()->email;
    $username = Auth::user()->name; 
    $messageData = [
        'leavecategory' => $leave->leavecategory,
        'leavetype' => $leave->leavetype,
        'issandwich' => $leave->issandwich,
        'fromdate'=>$leave->fromdate,
        'todate'=>$leave->todate,
        'noofdays' => $leave->noofdays,
        'reason' => $leave->reason,
        'username' => $username,
    ];

    Mail::send('emails.updateUserLeave', $messageData, function ($message) use ($email, $leave) {
        $message->to($email)
                ->subject('Leave Request')
                ->cc(json_decode($leave->cc));
    });

    return response()->json(['message' => 'Leave request updated successfully'], 200);
}


    public function deleteLeave(Request $request, $id)
{
    $leave = UserLeaves::find($id);
    if ($leave) {
        
        if ($leave->status == 'Approved') {
            return response()->json(['message' => 'Approved leave cannot be deleted.'], 403);
        } 
        $leave->delete();
        return response()->json(['message' => 'Leave deleted successfully.'], 200);
    } else {
        return response()->json(['message' => 'Leave not found.'], 404);
    }
}


    public function leaveDetails( Request $request,$id)
    {
        $leave = UserLeaves::where('id', $id)->first();
        if ($leave) {
            return response()->json($leave, 200);
        } else {
            return response()->json(['message' => 'Leave not found'], 404);
        }
       
    }

public function calculateCarryForwardLeaves($user)
{
    $currentMonth = Carbon::now()->month;
    $lastMonth = Carbon::now()->subMonth()->month;
    $monthBeforeLast = Carbon::now()->subMonths(2)->month;

    $lastMonthLeaves = UserLeaves::where('user_id', $user->id)
        ->whereMonth('fromdate', $lastMonth)
        ->where('status', 'Approved')
        ->sum('noofdays');
   
    $monthBeforeLastLeaves = UserLeaves::where('user_id', $user->id)
        ->whereMonth('fromdate', $monthBeforeLast)
        ->where('status', 'Approved')
        ->sum('noofdays');

     $carryForwardLeaves = 0;
    if ($lastMonthLeaves == 0) {
        $carryForwardLeaves += 1;
    }
    if ($monthBeforeLastLeaves == 0) {
        $carryForwardLeaves += 1;
    }
      
    $carryForwardLeaves = min($carryForwardLeaves, 2);
    $user->paidleaves =  $carryForwardLeaves;
    $user->save();

    return response()->json(['message' => 'Carry forward leaves calculated successfully', 'paidleaves' => $user->paidleaves]);
}


public function getUser()
{
    $user = Auth::user();
  
    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }
    return response()->json($user);
}

}
