<?php

namespace App\Http\Controllers;
use App\Models\Holidays;
use App\Models\ManagerLeaves;
use App\Models\User;
use App\Models\UserLeaves;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Log;

class AdminController extends Controller
{

public function getAdminLeave()
{
    $userLeaves = UserLeaves::orderBy('id', 'desc')
                            ->with('user:id,name')
                            ->get();
 
    $managerLeaves = ManagerLeaves::orderBy('id', 'desc')
                                  ->with('user:id,name')
                                  ->get();
                                
    $leaves = $userLeaves->merge($managerLeaves);
    $leaves = $leaves->values();
    return response()->json($leaves);
}



public function updateLeaveStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|string|in:Approved,Cancelled',
        'actionreason' => 'required|string',
    ]);

    $userLeave = UserLeaves::find($id);
    $managerLeave = ManagerLeaves::find($id);
    
    if ($userLeave) {
        $leave = $userLeave;
        $leaveType = 'UserLeaves';
        $user = User::find($leave->user_id);
    } elseif ($managerLeave) {
        $leave = $managerLeave;
        $leaveType = 'ManagerLeaves';
        $user = null; 
    } else {
        return response()->json(['error' => 'Leave not found'], 404);
    }

    $newStatus = $request->status;
    $oldStatus = $leave->status;
    if ($leaveType === 'UserLeaves') {
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        if ($newStatus === 'Approved' && $oldStatus !== 'Approved' && $leave->leavetype === 'Full Day') {
            $currentMonth = Carbon::now()->format('Y-m');
            $leaveMonth = Carbon::parse($leave->fromdate)->format('Y-m');
    
            if ($currentMonth === $leaveMonth) {
                $remainingPaidLeaves = $user->paidleaves;
                $paidLeavesToDeduct = min($leave->noofdays, $remainingPaidLeaves);
    
                $user->paidleaves -= $paidLeavesToDeduct;
                $user->save();
            }
        }
    
        elseif ($newStatus === 'Cancelled' && $oldStatus === 'Approved' && $leave->leavetype === 'Full Day') {
            $currentMonth = Carbon::now()->format('Y-m');
            $leaveMonth = Carbon::parse($leave->fromdate)->format('Y-m');
        
            if ($currentMonth === $leaveMonth) {
                $remainingPaidLeaves = $user->paidleaves;
                $leaveDays = $leave->noofdays;
        
                $paidLeavesDeducted = min($leaveDays, 2 - $remainingPaidLeaves); 
                $user->paidleaves += $paidLeavesDeducted;
                $user->paidleaves = min($user->paidleaves, 2); 
        
                $user->save();
            }
        }
              
    }
    
    $leave->status = $newStatus;
    $leave->actionreason = $request->actionreason;
    $leave->save();

    $userEmail = $user ? $user->email : null;
    $userName = $user ? $user->name : 'Manager';
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

    if ($userEmail) {
        Mail::send($emailTemplate, $messageData, function ($message) use ($userEmail, $subject) {
            $message->to($userEmail)->subject($subject);
        });
    }

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
   $holidays = Holidays::orderBy('date','DESC')->get();
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
    $users = User::whereIn('role', ['user', 'manager'])->get();  
    $userLeaves = UserLeaves::with('user')->get()->groupBy('user_id');

    $data = $users->map(function ($user) use ($userLeaves) {
        $leaves = $userLeaves->get($user->id, collect()); 

       
        $leavesData = $leaves->map(function ($leave) {
            return [
                'leavetype' => $leave->leavetype,
                'status' => $leave->status,
                'fromdate' => Carbon::parse($leave->fromdate)->format('Y-m-d'),
                'todate' => Carbon::parse($leave->todate)->format('Y-m-d'),
            ];
        });
        return [
            'employee_name' => $user->name,
            'leaves' => $leavesData,
        ];
    });

    return response()->json($data);
}

}
