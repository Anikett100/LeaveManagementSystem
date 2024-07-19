<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class ApiController extends Controller
{

    // login 
    public function product(Request $request){
        $data = $request->all();
        // dd($data);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
    
        $data = $user->save();
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

    // for get 
    public function getProducts()
    {
        $login = Login::get();
        return response()->json($login);
    } 

    public function getData()
    {
        // Example data (you can replace this with data from a model or database)
        $data = [
            'message' => 'Hello, this is a simple GET API response!',
            'status' => 'success',
        ];

        return response()->json($data);
    }
}
