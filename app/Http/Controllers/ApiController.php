<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
class ApiController extends Controller
{
    public function getData()
    {
        return ["name"=>"Kamran"];
    }

    public function information($id=null)
    {
        return $id?User::find($id):User::all();
    }
    public function addInformation(Request $request)
    {
        $rules = array(
            "name"=>"required",
            "address"=>"required",
            "phone"=>"required|min:5|max:10"
        );

        $validation = Validator::make($request->all(),$rules);

        if($validation->fails())
        {
            // return $validation->errors();
            return response()->json($validation->errors(),401);
        }
        else
        {
            $user = new User();
            $user->name = $request->name;
            $user->address = $request->address;
            $user->phone = $request->phone;

            $result = $user->save();

            if($result)
            {
                return ["result"=>"Data added Successfuly"];
            }
            else
            {
                return ["result"=>"Data addition failed"];
            }
        }
        
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);

        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;

        $result = $user->update();

        if($result)
        {
            return ['result'=>"Information Updated"];
        }
        else
        {
            return ['result'=>"Information Updation Failed"];
        }
    }
    public function search($name)
    {
        $user = User::where('name','like','%'.$name.'%')->get();

        if(count($user))
        {
            return $user;
        }
        else
        {
            return "Result not found for ".$name;
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        $result = $user->delete();

        if($result)
        {
            return "Record Deleted";
        }
        else
        {
            return "Record not Deleted";
        }
    }
}
