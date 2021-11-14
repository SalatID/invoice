<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Invoicem;
use App\Models\Invoiced;
use DB;
use PDF;

class InvController extends Controller
{
    public function index(){
        return view('invList');
    }

    public function addPage(){
        $vendors = Vendor::get();
        return view('invAdd',compact('vendors'));
    }

    public function editPage(){
        $vendors = Vendor::get();
        $dataInv = Invoicem::where(["invId"=>request('invId')])->first();
        return view('invEdit',compact('vendors','dataInv'));
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
            $dataInv = Invoiced::select('tblinvd.*','b.description','b.unitPrice','b.curCd','b.itemId','b.itemType')
                    ->join('tblitem as b','b.itemId','tblinvd.itemId')
                    ->where($params )->get();
                    return ["error"=>false,"message"=>"Data Found","params"=>$dataInv];
        } catch (Exception $e) {
            return ["error"=>"003","message"=>"Something Wrong ".$e];
        }
        
    }
    public function getInvList(){
        $params = request()->all();
        try {
            if(array_key_exists('invId',$params)){
                $params['tblinvm.invId'] = $params['invId'];
                $detail = Invoiced::where(['invId'=>$params['invId']])->get();
                unset($params['invId']);
            }
            $dataInv = Invoicem::select('tblinvm.*','b.amount','c.name as senderNm','d.name as receiverNm','c.address as senderAddr','d.address as receiverAddr')
                    ->leftJoin(DB::raw("
                    (
                        select sum(a.qty * b.unitPrice)amount,invId
                        from tblinvd a 
                        join tblitem b on a.itemId = b.itemId
                        group by a.invId
                    ) as b"),'b.invId','tblinvm.invId')
                    ->join('tblvendor as c','c.vendId','tblinvm.senderId')
                    ->join('tblvendor as d','d.vendId','tblinvm.senderId')
                    ->where($params )->orderBy('tblinvm.invId')->get();
                    if(count($dataInv->toArray()) ==1){
                        $dataInv = $dataInv[0];
                        $dataInv['detail'] = $detail;
                    }
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

    public function updInv()
    {
        $params = request()->all();
        $invId = $params['invId'];
        unset($params['invId']);
        $totalAmount = Invoiced::join('tblitem as b','b.itemId','tblinvd.itemId')
        ->where(["invId"=>$invId])->sum(DB::raw('qty*b.unitPrice'));
        $params["invStatus"] = $params["payments"]>=$totalAmount?'PAID':'UNPAID';
        return Invoicem::updateData($params,$invId);
    }

    public function delInv()
    {
        $params = request()->all();
        return Invoiced::deleteData(["invId"=>$params["invId"],"itemId"=>$params["itemId"]]);
    }

    public function delInvM()
    {
        $params = request()->all();
        return Invoicem::deleteData(["invId"=>$params["invId"]]);
    }

    public function invPdf()
    {
        $invM = $this->getInvList()['params'];
        $invD = $this->getList()['params'];
        return view('invDetail',compact('invM','invD'));
    }
}
