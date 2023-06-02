<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\FileOperations\imageOperation;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Request()->has('page') ? Request()->get('page') : 1;
        $brandName =Request()->has('name') ? Request()->get('name') : "";
        $limit =Request()->has('limit') ? Request()->get('limit') : 5;
        $brands = Brand::where('delete_status',1)
                        ->where(function($query) use ($brandName){
               if($brandName){
                $query->where('name','LIKE','%'.$brandName . '%');
               }
               return $query;
        });
        return response()->json([
            'data' => $brands->orderBy('id','asc')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->get(),
        'message' => 'User list.',
        'total' => $brands->count(),
        'page' => (int)$page,
        'rowPerPages' => (int)$limit,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
          $validated = $request->validated();
       if (isset($request->brand_image)) {
        $operation = new imageOperation($request->brand_image,$request->name,'brand');
        $url = $operation->storeImage();
        $validated['brand_image'] = $url;
    }
    $data = Brand::create($validated);
    return new BrandResource($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request,Brand $brand)
    {
        // return $id;
        $validated = $request->validated();
        // return $validated;
        if (isset($request->brand_image)) {
         $operation = new imageOperation($request->brand_image,$request->name,'brand');
         $url = $operation->storeImage();
         $validated['brand_image'] = $url;
     }
    if($validated['brand_image'] == null){
        $validated['brand_image']= $brand->brand_image;
         $brand->update($validated);
          return response()->json([
                           "error"=>false,
                           "message"=>"Updated Without Image Successfully",

                ]);

    }else{
       $brand->update($validated);
         return response()->json([
                            "error"=>false,
                           "message"=>"Updated with Image Successfully",

               ]);
    };

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    $brand = Brand::find($id);
    if($brand){
        $brand->delete_status =0;
        if($brand->save()){
            return response()->json([
                            "error"=>false,
                            "message"=>"Brand  Deleted Success",
                            "data"=>$brand
                           ]);

        }
    }

    }
}
