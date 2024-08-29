<?php

namespace App\Http\Controllers;

use App\Models\Holidays;
use App\Models\User;
use App\Models\UserLeaves;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
  public function getAdminLeave(){
    $leaves = UserLeaves::orderBy('id','desc')->with('user:id,name')->get();
    return response()->json($leaves);
  }


// this is for deduct paid leave  
// public function updateLeaveStatus(Request $request, $id)
// {
//     $request->validate([
//         'status' => 'required|string|in:Approved,Cancelled',
//         'actionreason' => 'required|string',
//     ]);

//     $leave = UserLeaves::findOrFail($id);
//     $newStatus = $request->status;
//     $oldStatus = $leave->status;
//     $user = User::find($leave->user_id);

//     if (!$user) {
//         return response()->json(['error' => 'User not found'], 404);
//     }

//     if ($newStatus === 'Approved' && $oldStatus !== 'Approved') {
//         $currentMonth = Carbon::now()->format('Y-m');
//         $leaveMonth = Carbon::parse($leave->fromdate)->format('Y-m');

//         if ($currentMonth === $leaveMonth) {
//             $remainingPaidLeaves = $user->paidleaves;
//             $paidLeavesToDeduct = min($leave->noofdays, $remainingPaidLeaves);
//             $user->paidleaves -= $paidLeavesToDeduct;
//             $user->save();
//         }
//     }

//     $leave->status = $newStatus;
//     $leave->actionreason = $request->actionreason;
//     $leave->save();

//     $email = ['aniketnavale2712@gmail.com'];
//     $messageData = [
//         'leavetype' => $leave->leavetype,
//         'leavecategory' => $leave->leavecategory,
//         'issandwich' => $leave->issandwich,
//         'fromdate' => $leave->fromdate,
//         'todate' => $leave->todate,
//         'noofdays' => $leave->noofdays,
//         'reason' => $leave->reason,
//         'actionreason' => $leave->actionreason,
//     ];

//     $subject = $newStatus === 'Approved' ? 'Leave Approved' : 'Leave Cancelled';
//     $emailTemplate = $newStatus === 'Approved' ? 'emails.approvedLeave' : 'emails.cancelledLeave';

//     Mail::send($emailTemplate, $messageData, function ($message) use ($email, $subject) {
//         $message->to($email)->subject($subject);
//     });

//     return response()->json(['message' => "Leave $newStatus successfully"]);
// }


public function updateLeaveStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|string|in:Approved,Cancelled',
        'actionreason' => 'required|string',
    ]);

    $leave = UserLeaves::findOrFail($id);
    $newStatus = $request->status;
    $oldStatus = $leave->status;
    $user = User::find($leave->user_id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    if ($newStatus === 'Approved' && $oldStatus !== 'Approved') {
        $currentMonth = Carbon::now()->format('Y-m');
        $leaveMonth = Carbon::parse($leave->fromdate)->format('Y-m');

        if ($currentMonth === $leaveMonth) {
            $remainingPaidLeaves = $user->paidleaves;
            $paidLeavesToDeduct = min($leave->noofdays, $remainingPaidLeaves);
            $user->paidleaves -= $paidLeavesToDeduct;
            $user->save();
        }
    }

    $leave->status = $newStatus;
    $leave->actionreason = $request->actionreason;
    $leave->save();
    $userEmail = $user->email;
    $userName = $user->name;
    $messageData = [
        'username' => $userName,
        'leavetype' => $leave->leavetype,
        'leavecategory' => $leave->leavecategory,
        'issandwich' => $leave->issandwich,
        'fromdate' => $leave->fromdate,
        'todate' => $leave->todate,
        'noofdays' => $leave->noofdays,
        'reason' => $leave->reason,
        'actionreason' => $leave->actionreason,
    ];

   
    $subject = $newStatus === 'Approved' ? 'Leave Approved' : 'Leave Cancelled';
    $emailTemplate = $newStatus === 'Approved' ? 'emails.approvedLeave' : 'emails.cancelledLeave';

 
    Mail::send($emailTemplate, $messageData, function ($message) use ($userEmail, $subject) {
        $message->to($userEmail)->subject($subject);
    });

    return response()->json(['message' => "Leave $newStatus successfully"]);
}



public function addHoliday(Request $request){  
    $holiday = new Holidays;
    $holiday->name = $request->name;
    $holiday->date = $request->date;
    $holiday->day = $request->day;
    $holiday->type = $request->type;
    $data = $holiday->save();

    if ($data) {
        return response()->json([
            'status' => 200,
            'message' => 'Data saved successfully',
        ]);
    } else {
        return response()->json([
            'status' => 400,
            'error' => 'Something went wrong',
        ]);
    }
}


    //   for table
  public function getHoliday()
  {
   $holidays = Holidays::get();
   return response()->json($holidays);
     
  }

//  for calender
  public function getHolidaysAndEvents()
{
    $holidays = Holidays::all();

    return response()->json([
        'status' => 200,
        'holidays' => $holidays,
    ]);
}

  public function deleteHoliday(Request $request, $id)
    {
        $holiday = Holidays::find($id);
        if ($holiday) {
            $holiday->delete();
            return response()->json(['message' => 'holiday deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'holiday not found.'], 404);
        }
    }


    public function updateHoliday(Request $request, $id) {
      $holiday = Holidays::findOrFail($id);
      $holiday->day = $request->input('day');
      $holiday->date = $request->input('date');
      $holiday->name = $request->input('name');
      $holiday->type = $request->input('type');
      $data = $holiday->save();
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


    public function attendance(Request $request)
{
    $userLeaves = UserLeaves::with('user')->get();
    $data = $userLeaves->groupBy('user_id')->map(function ($leaves) {
        $employeeName = $leaves->first()->user->name;
        $leavesData = $leaves->map(function ($leave) {
            return [
                'leavetype' => $leave->leavetype,
                'status' => $leave->status,
                'fromdate' => Carbon::parse($leave->fromdate)->format('Y-m-d'),
                'todate' =>Carbon::parse( $leave->todate)->format('Y-m-d')
            ];
        });
        return [
            'employee_name' => $employeeName,
            'leaves' => $leavesData,
        ];
    });
    return response()->json($data);
}
    
    
}
