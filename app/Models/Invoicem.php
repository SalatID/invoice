<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validator;

class Invoicem extends Model
{
    use HasFactory;
    protected $table ='tblinvm';
    public $timestamps = false;

    public function generateId()
    {
        return sprintf('%04s',(self::max('invId')??0)+1);
    }

    public function validateForm($data)
    {
        $validate = [
            'subject'=>'required',
            'senderId'=>'required',
            'receiverId'=>'required',
            'dueDt'=>'required'
        ];
        $validator = Validator::make($data,$validate);
        if ($validator->fails()) {
            return false;
          }
          return true;
    }

    public static function insertData($data)
    {
      if (self::validateForm($data)) {
        $data["invId"]=self::generateId();
        $data["createdAt"]=date("Y-m-d H:i:s");
        $data["createdUser"]='0001';
        //dd(self::insert($data));
        try {
            if (self::insert($data)) {
                return ["error"=>false,"message"=>"Add Invoice Successful","params"=>$data];
              }
              return ["error"=>"001","message"=>"Add Invoice Failed"];
        } catch (Exception $e) {
            return ["error"=>"003","message"=>"Something Wrong ".$e];
        }
        
      }
      return ["error"=>"002","message"=>"There is an empty field"];
    }

    public static function updateData($data,$id)
    {
        $data["updatedAt"]=date("Y-m-d H:i:s");
        $data["updatedUser"]='0001';
        //dd(self::insert($data));
        if (self::where(['invId'=>$id])->update($data)) {
          return ["error"=>false,"message"=>"Update Invoice Successfull"];
        }
        return ["error"=>true,"message"=>"Update Invoice Failed"];
    }

    public static function deleteData($id)
    {
      if (self::where(['invId'=>$id])->delete()) {
        return ["error"=>false,"message"=>"Delete Invoice Successfull"];
      }
      return ["error"=>true,"message"=>"Delete Invoice Failed"];
    }
}
