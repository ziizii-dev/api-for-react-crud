<?php
namespace App\FileOperations;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Traits\ImagePathTrait;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Carbon;

class imageOperation{

use ImagePathTrait;
private $file,$folderName,$fileName;

    public function __construct($image_file,$folder_name,$photo_path){
        $this->file = $image_file;
        $this->folderName = $folder_name;
        $this->fileName = $photo_path;
    }
    public function storeImage(){
        $file = $this->StoreBase64Image();
        // return $file;
        $filePath = '/upload'.'/'.$this->fileName.'/'. $this->folderName . '/' . Carbon::now()->format('Y') . '/' . Str::uuid() . '.'  . $file['type'];
        Storage::disk('public_uploads')->put($filePath, $file['data']);
        return $this->url . $filePath;
    }

    public function StoreBase64Image()
    {
        //return $this->file;
        $image_parts = explode(";base64,", $this->file);
        $image_type_aux = explode("image/", $image_parts[0] ?? null);
        $image_type = $image_type_aux[1] ?? null;
        $image_base64 = base64_decode($image_parts[1] ?? null) ;
        return [
            'type' => $image_type,
            'data' => $image_base64,
        ];

    }
}
