<?php

namespace App\Http\Controllers;

use App\Models\UserList;
use App\Http\Requests\StoreUserListRequest;
use App\Http\Requests\UpdateUserListRequest;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  UserList::where('status',1)->get();

        return response()->json([
            "error"=>"false",
            "message"=>"userlist",
            "data"=>$data
        ]);
    }
    // public function details(Request $request, $id)
    // {
    //     return $id;
    //     $data =  UserList::where('id',$id)->first();

    //     return response()->json([
    //         "error"=>"false",
    //         "message"=>"userlist",
    //         "data"=>$data
    //     ]);
    // }
//  public function details(Request $request,$id){
//     $data = UserList::where('id',$id)->first();
//  }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //   return $request;
        $validator = $request->validate([
            "name" =>"required|string",
            "email"=>"required|string",
            "phone"=>"required|string",
            "address"=>"required|string",
            // "status"=>"nullable|integer"
        ]);
       $data = UserList::create($validator);
        return response()->json([
            "error"=>"false",
            "message"=>"create success",
            "data"=>$data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserList  $userList
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
       // return $id;
        // $table->enum('is_approved', array('0','1'))->default('0')->change();
        //  return $id;

        // $data = [
        //      "id"=> $request->id,
        //     "name"=>$request->name,
        //     "email"=>$request->email,
        //     "phone"=>$request->phone,
        //     "address"=>$request->address
        //    ];'id',$request->id
        //    return $data;
        $response = UserList::with("todos")->where([
            ['status','=',1],
            ['id',$id]
           ])->first();
        // return $response;
        if(isset($response)){
            // $data = UserList::with("todos")->where([
            //     ['status','=',1],
            //     ['id',$request->id]

            //    ])->first();
            // return $response;
        return response()->json([
            "error"=>false,
            "message"=>" success",
            "data"=>$response
           ]);
        }
        // return $response;
        return response()->json([
            "error"=>true,
            "message"=>" there is no data",
            "data"=>$response
           ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserList  $userList
     * @return \Illuminate\Http\Response
     */
    public function edit(UserList $userList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserListRequest  $request
     * @param  \App\Models\UserList  $userList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // return $id;
           $data =[
            "name"=>$request->name,
            "email"=>$request->email,
            "phone"=>$request->phone,
            "address"=>$request->address
           ];
           $update = UserList::where([
            ['status','=',1],
            ['id','=',$id]

           ])->first();
        //   return $update;
        if(isset($update)){
            $response= UserList::findOrFail($id)->update($data);
            // return $response;
            return response()->json([
                "error"=>false,
                "message"=>"update success",
                "data"=>$response
               ]);
        }
           return response()->json([
            "error"=>true,
            "message"=>"there is no data",
            "data"=>$update
           ]);
    }

    //.................
    // public function deleteCategory($id,Request $request){

    //     $data = Category::where('id',$request->id)->first();
    //     // return $data;
    //     if(isset($data)){
    //         Category::where('id',$request->id)->delete();
    //         return response()->json([  'status'=>'true','message'=>'delete success','deleteData'=>$data],200);
    //     }
    //     return response()->json(['status'=>'false', 'message'=>'there is no data' ],200);

    //     }
//.....................
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserList  $userList
     * @return \Illuminate\Http\Response
     */

     public function destroy($id)
    {

        // $data = UserList::where([
        //     ['status','=',1],
        //     ['id','=',$id]

        //    ])->first();
        // // return $data;
        // if(isset($data)){
        //    $response= UserList::where([
        //     ['status','=',1],
        //     ['id','=',$id]

        //    ])->delete();
        //     // return $response;
        //     return response()->json([
        //         "error"=>false,
        //         "message"=>"delete success",
        //         "data"=>$response
        //        ],200);
        // }

        $user = UserList::find($id);
        if($user){
            $user->status = 0;
           if($user->save()) {
            return response()->json([
                "error"=>false,
                "message"=>"delete success",
                "data"=>$user
               ],200);
           }
           return response()->json([
                    "error"=>true,
                    "message"=>"There is no data",
                    "data"=>$user
                   ],200);


        }
    }
    // public function destroy($id)
    // {

    //     $delete = UserList::where('id',$id)->first();
    //     if(isset($delete)){
    //         UserList::where('id',$id)->delete();
    //         return response()->json([
    //             "error"=>false,
    //             "message"=>"delete success",
    //             "data"=>$delete
    //            ],200);
    //     }
    //     return response()->json([
    //         "error"=>true,
    //         "message"=>"There is no data",
    //         "data"=>$delete
    //        ],200);
    // }
}
