<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
           "name"=>"required|string",
           'brand_image'=>"nullable|string",
        ];
    }
public function mesages(){
        return[
            "name.required"=>"Brand Name is requires",
            "brand_image.required"=>"Image is required"
        ];
    }
    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
           "error"=>true,
           "message"=>"Validation Failed",
           "data"=>$validator->errors()
        ]));
    }

}
