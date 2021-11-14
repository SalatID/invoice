<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validator;

class Invoiced extends Model
{
    use HasFactory;
    protected $table ='tblinvd';
    public $timestamps = false;

    public function generateSeq($p)
    {
        return (self::where($p)->max('seq')??0)+1;
    }

    public function validateForm($data)
    {
        $validate = [
            'invId'=>'required',
            'itemId'=>'required',
            'qty'=>'required',
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
        $data["seq"]=self::generateSeq(['invId'=>$data['invId']]);
        $data["createdAt"]=date("Y-m-d H:i:s");
        $data["createdUser"]='0001';
        //dd(self::insert($data));
        $p = ["invId"=>$data["invId"],"itemId"=>$data["itemId"]];
        if(self::where($p)->exists()){
            self::where($p)->update(["qty"=>(self::select('qty')->where($p)->first()->qty+$data['qty'])]);
            return ["error"=>false,"message"=>"Add Item Successful"];
        }
        if (self::insert($data)) {
          return ["error"=>false,"message"=>"Add Item Successful"];
        }
        return ["error"=>"001","message"=>"Add Item Failed"];
      }
      return ["error"=>"002","message"=>"There is an empty field"];
    }

    public static function updateData($data,$p)
    {
        $data["updatedAt"]=date("Y-m-d H:i:s");
        $data["updatedUser"]='0001';
        //dd(self::insert($data));
        if (self::where($p)->update($data)) {
          return ["error"=>false,"message"=>"Update Item Successfull"];
        }
        return ["error"=>true,"message"=>"Update Item Failed"];
    }

    public static function deleteData($id)
    {
      if (self::where($id)->delete()) {
        return ["error"=>false,"message"=>"Delete Item Successfull"];
      }
      return ["error"=>true,"message"=>"Delete Item Failed"];
    }
}
