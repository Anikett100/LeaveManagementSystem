<?php

namespace App\Http\Controllers;
use App\Models\ManagerLeaves;
use App\Models\User;
use App\Models\UserLeaves;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\CancelLeaveMail;
use Log;
use Validator;

class UserController extends Controller
{
    //    public function AddLeave(Request $request)
    // {
    //     $leave = new UserLeaves;
    //     $leave->leavecategory = $request->leavecategory;
    //     $leave->leavetype = $request->leavetype;
    //     $leave->issandwich = $request->issandwich;
    //     $leave->cc = json_encode($request->cc);
    //     $leave->fromdate = $request->fromdate;
    //     $leave->todate = $request->todate;
    //     $leave->noofdays = $request->noofdays;
    //     $leave->reason = $request->reason;
    //     $leave->user_id = $request->user_id;
    //     $data = $leave->save();
    //     $user = auth()->user();

    //     if ($data) {     
    //         $email = ['kartik@ycstech.in'];
    //         $messageData = [
    //              'username' => $user->name,
    //             'leavecategory' => $leave->leavecategory,
    //             'leavetype' => $leave->leavetype,
    //             'issandwich' => $leave->issandwich,
    //             'fromdate' => $leave->fromdate,
    //             'todate' => $leave->todate,
    //             'noofdays' => $leave->noofdays,
    //             'reason' => $leave->reason,
    //         ];

    //         Mail::send('emails.userLeave', $messageData, function ($message) use ($email, $leave) {
    //             $message->to($email)
    //                 ->subject('Leave Request')
    //                 ->cc(json_decode($leave->cc));
    //         });
    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Data saved and email sent successfully',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 400,
    //             'error' => 'Something went wrong',
    //         ]);
    //     }
    // }


    public function AddLeave(Request $request)
    {
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
            $email = ['kartik@ycstech.in'];
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

            Mail::to($email)
            ->cc(json_decode($leave->cc))
            ->queue(new \App\Mail\UserLeaveMail($messageData));
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


    // public function updateLeave(Request $request)
    // {
    //     $leave = UserLeaves::find($request->id);
    //     if (!$leave) {
    //         return response()->json(['error' => 'Leave record not found'], 404);
    //     }
    //     $leave->leavetype = $request->leavetype;
    //     $leave->leavecategory = $request->leavecategory;
    //     $leave->cc = json_encode($request->cc);
    //     $leave->reason = $request->reason;
    //     $leave->fromdate = $request->fromdate;
    //     $leave->todate = $request->todate;
    //     $leave->noofdays = $request->noofdays;
    //     $leave->issandwich = $request->issandwich;
    //     $leave->save();

    //     $email = Auth::user()->email;
    //     $username = Auth::user()->name;
    //     $messageData = [
    //         'leavecategory' => $leave->leavecategory,
    //         'leavetype' => $leave->leavetype,
    //         'issandwich' => $leave->issandwich,
    //         'fromdate' => $leave->fromdate,
    //         'todate' => $leave->todate,
    //         'noofdays' => $leave->noofdays,
    //         'reason' => $leave->reason,
    //         'username' => $username,
    //     ];

    //     Mail::send('emails.updateUserLeave', $messageData, function ($message) use ($email, $leave) {
    //         $message->to($email)
    //             ->subject('Leave Request')
    //             ->cc(json_decode($leave->cc));
    //     });

    //     return response()->json(['message' => 'Leave request updated successfully'], 200);
    // }




    // public function updateLeave(Request $request)
    // {
    //     $leave = UserLeaves::find($request->id);
    //     if (!$leave) {
    //         return response()->json(['error' => 'Leave record not found'], 404);
    //     }
    //     $leave->leavetype = $request->leavetype;
    //     $leave->leavecategory = $request->leavecategory;
    //     $leave->cc = json_encode($request->cc);
    //     $leave->reason = $request->reason;
    //     $leave->fromdate = $request->fromdate;
    //     $leave->todate = $request->todate;
    //     $leave->noofdays = $request->noofdays;
    //     $leave->issandwich = $request->issandwich;
    //     $leave->save();

    //     $email = Auth::user()->email;
    //     $username = Auth::user()->name;
    //     $messageData = [
    //         'leavecategory' => $leave->leavecategory,
    //         'leavetype' => $leave->leavetype,
    //         'issandwich' => $leave->issandwich,
    //         'fromdate' => $leave->fromdate,
    //         'todate' => $leave->todate,
    //         'noofdays' => $leave->noofdays,
    //         'reason' => $leave->reason,
    //         'username' => $username,
    //     ];

    //     Mail::send('emails.updateUserLeave', $messageData, function ($message) use ($email, $leave) {
    //         $message->to($email)
    //             ->subject('Leave Request')
    //             ->cc(json_decode($leave->cc));
    //     });

    //     return response()->json(['message' => 'Leave request updated successfully'], 200);
    // }
        

    public function updateLeave(Request $request)
    {
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
            'fromdate' => $leave->fromdate,
            'todate' => $leave->todate,
            'noofdays' => $leave->noofdays,
            'reason' => $leave->reason,
            'username' => $username,
        ];
        Mail::to($email)
        ->cc(json_decode($leave->cc))
        ->queue(new \App\Mail\UpdateUserLeave($messageData));
        return response()->json([
            'status' => 200,
            'message' => 'Data saved and email sent successfully',
        ]);   
    }

    public function getLeave()
    {
        $userId = auth()->id();
        $leave = UserLeaves::where('user_id', $userId)->orderBy('id', 'desc')->get();
        return response()->json($leave);
    }
    
    public function getApprovedLeave()
    {
        $userId = auth()->id();
        $userLeaves = UserLeaves::where('user_id', $userId)
            ->where('status', 'Approved')
            ->orderBy('id', 'desc')
            ->get();

        $managerLeaves = ManagerLeaves::where('user_id', $userId)
            ->where('status', 'Approved')
            ->orderBy('id', 'desc')
            ->get();
        $allLeaves = $userLeaves->merge($managerLeaves);
        return response()->json(['leaves' => $allLeaves]);
    }

    // for sandwich leave logic
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
    public function leaveDetails(Request $request, $id)
    {
        $leave = UserLeaves::where('id', $id)->first();
        if ($leave) {
            $leave->type = 'User';
            return response()->json($leave, 200);
        }
        $leave = ManagerLeaves::where('id', $id)->with('user:id,name')->first();
        if ($leave) {
            $leave->type = 'Manager';
            $leave->manager_name = $leave->user ? $leave->user->name : 'Unknown';
            return response()->json($leave, 200);
        }

        return response()->json(['message' => 'Leave not found'], 404);
    } 
    
    
    public function calculateCarryForwardLeaves()
{
    $lastMonth = Carbon::now()->subMonth()->month;
    $monthBeforeLast = Carbon::now()->subMonths(2)->month;
    $users = User::whereIn('role', ['user', 'manager'])->get();

    foreach ($users as $user) {
      
        $calculateLeaveDays = function ($leaveModel, $userId, $month) {
            return $leaveModel::where('user_id', $userId)
                ->where(function ($query) use ($month) {
                    $query->whereMonth('fromdate', $month)
                        ->orWhereMonth('todate', $month);
                })
                ->where('status', 'Approved')
                ->get()
                ->sum(function ($leave) use ($month) {
                    $fromDate = Carbon::parse($leave->fromdate);
                    $toDate = Carbon::parse($leave->todate);

                    $start = $fromDate->month == $month
                        ? $fromDate
                        : Carbon::now()->subMonth()->startOfMonth();

                    $end = $toDate->month == $month
                        ? $toDate
                        : Carbon::now()->subMonth()->endOfMonth();

                    return $start->diffInDays($end) + 1;
                });
        };

        $lastMonthLeaves = $calculateLeaveDays(UserLeaves::class, $user->id, $lastMonth) +
            $calculateLeaveDays(ManagerLeaves::class, $user->id, $lastMonth);

        $monthBeforeLastLeaves = $calculateLeaveDays(UserLeaves::class, $user->id, $monthBeforeLast) +
            $calculateLeaveDays(ManagerLeaves::class, $user->id, $monthBeforeLast);

        $carryForwardLeaves = 0;
        if ($lastMonthLeaves == 0 && $monthBeforeLastLeaves == 0) {
            $carryForwardLeaves = 2;
        } elseif ($lastMonthLeaves == 0 || $monthBeforeLastLeaves == 0) {
            $carryForwardLeaves = 1;
        }

        $user->paidleaves = $carryForwardLeaves;
        $user->save();
    }

    return redirect()->back()->with('success', 'Carry forward leaves calculated for all users and managers successfully.');
}

    public function getUser()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        return response()->json($user);
    }

    // mail function for request for  cancel approved leave 
//     public function cancelLeave(Request $request, $id)
// {
//     $leaveId = $id;  
//     $reason = $request->reason;
//     $fromdate=$request->fromdate;
//     $todate=$request->todate;


//     try {
//         $data = [
//             'leaveId' => $leaveId,
//             'reason' => $reason,
//             'todate'=>$todate,
//             'fromdate'=>$fromdate,
//         ];
//         Mail::to("kartik@ycstech.in")->queue(new CancelLeaveMail($data));;

//         return response()->json(['message' => 'Cancellation request sent.'], 200);
//     } catch (\Exception $e) {
//         return response()->json(['message' => 'Failed to send cancellation request.'], 500);
//     }
// }


public function cancelLeave(Request $request, $id)
{
    $leaveId = $id;
    $reason = $request->reason;
    try {
        $leave = UserLeaves::find($leaveId);
        if (!$leave) {
            $leave = ManagerLeaves::find($leaveId);
            if (!$leave) {
                return response()->json(['message' => 'Leave not found.'], 404);
            }
        }
        $data = [
            'leaveId' => $leaveId,
            'reason' => $reason,
            'fromdate' => $leave->fromdate,
            'todate' => $leave->todate,
        ];
        Mail::to("kartik@ycstech.in")->queue(new CancelLeaveMail($data));
        return response()->json(['message' => 'Cancellation request sent.'], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to send cancellation request.',
            'error' => $e->getMessage(),
        ], 500);
    }
}



}
