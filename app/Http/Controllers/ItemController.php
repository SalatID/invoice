<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function getList()
    {
        $params = request()->all();
        $par = [];
        if(array_key_exists('description',$params)){
            array_push($par,[
                'description','like',$params['description'].'%'
            ]);
        }

        if(array_key_exists('itemId',$params)){
            array_push($par,[
                'itemId','like',$params['itemId'].'%'
            ]);
        }

        return response()->json(Item::where($par)->get());
    }
}
