<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Invoicem;
use App\Models\Invoiced;

class InvController extends Controller
{
    public function index(){
        return view('invList');
    }

    public function addPage(){
        $vendors = Vendor::get();
        return view('invAdd',compact('vendors'));
    }

    public function add()
    {
        return response()->json(Invoicem::insertData(request()->all()));
    }

    public function addDetail()
    {
        return response()->json(Invoiced::insertData(request()->all()));
    }

    public function getList()
    {
        $params = request()->all();
        try {
            $dataInv = Invoiced::select('tblinvd.*','b.description','b.unitPrice','b.curCd','b.itemId')
                    ->join('tblitem as b','b.itemId','tblinvd.itemId')
                    ->where($params )->get();
                    return ["error"=>false,"message"=>"Data Found","params"=>$dataInv];
        } catch (Exception $e) {
            return ["error"=>"003","message"=>"Something Wrong ".$e];
        }
        
    }
    public function updQty()
    {
        $params =request()->all();
        return Invoiced::updateData(["qty"=>$params["qty"]],["invId"=>$params["invId"],"itemId"=>$params["itemId"]]);
    }

    public function delInv()
    {
        $params = request()->all();
        return Invoiced::deleteData(["invId"=>$params["invId"],"itemId"=>$params["itemId"]]);
    }
}
