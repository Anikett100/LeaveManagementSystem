<?php

namespace App\Http\Controllers;

use App\Models\UserLeaves;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function AddLeave(Request $request){
        $data = $request->all();
        //  dd($data);
        $leave = new UserLeaves;
        $leave->leavecategory = $request->leaveCategory;
        $leave->leavetype = $request->leaveType;
        $leave->fromdate = $request->fromDate;
        $leave->todate = $request->toDate;
        $leave->noofdays = $request->noOfDays;
        $leave->reason = $request->reason;
        $data = $leave->save();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'data saved successfully',
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
        $leave = UserLeaves::get();
        return response()->json($leave);
       
    }
// public function updateLeave(Request $request, $id) {
//     $leave = UserLeaves::find($id);
    
//     if (!$leave) {
//         return response()->json(['message' => 'Leave not found'], 404);
//     }
//     $leave->leavetype = $request->input('leaveType');
//     $leave->leavecategory = $request->input('leaveCategory');
//     $leave->fromdate = $request->input('fromDate');
//     $leave->todate = $request->input('toDate');
//     $leave->noofdays = $request->input('noOfDays');
//     $leave->reason = $request->input('reason');
//     $leave->save();

//     return response()->json(['message' => 'Leave updated successfully'], 200);
// }

public function updateLeave(Request $request, $id) {
    $leave = UserLeaves::findOrFail($id);
    $leave->leavecategory = $request->leaveCategory;
    $leave->leavetype = $request->leaveType;
    $leave->fromdate = $request->fromDate;
    $leave->todate = $request->toDate;
    $leave->noofdays = $request->noOfDays;
    $leave->reason = $request->reason;
    $data = $leave->save();

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



    public function deleteLeave(Request $request, $id)
    {
        $leave = UserLeaves::find($id);
        if ($leave) {
            $leave->delete();
            return response()->json(['message' => 'Leave deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Leave not found.'], 404);
        }
    }
}
