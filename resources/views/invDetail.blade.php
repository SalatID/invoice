@extends('index')
@section('title', 'Detail Invoice')

@section('content')

    <!-- Content Row -->

    <div class="row mt-2">
        <div class="col-md-12 table-responsive text-center">
            <img src="/{{strtolower($invM->invStatus)}}.png" width="15%" style="position: absolute;margin-top:2vh" alt="">
            <table class="table">
                <tr>
                    <td colspan="2" style="font-size : 100px;">INVOICE</td>
                    <td>From</td>
                    <td><Strong>{{$invM->senderNm}}</Strong> <br>{{$invM->senderAddr}}</td>
                </tr>
                <tr>
                    <td>Invoice ID</td>
                    <td>{{$invM->invId}}</td>
                    <td rowspan="3">For</td>
                    <td rowspan="3" style="width : 150px;"><strong>{{$invM->receiverNm}}</strong>  <br> {{$invM->receiverAddr}}</td>
                </tr>
                <tr>
                    <td>Issue Date</td>
                    <td>{{date_format(date_create($invM->createdAt),"d/m/Y")}}</td>
                </tr>
                <tr>
                    <td>Due Date</td>
                    <td>{{date_format(date_create($invM->dueDt),"d/m/Y")}}</td>
                </tr>
                <tr>
                    <td>Subject</td>
                    <td colspan="4">{{$invM->subject}}</td>
                </tr>
                <tr>
                    <th>Item Type</th>
                    <th>Desription</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                </tr>
                
                @php($subTotal = [])
                @php($curCd="")
                @foreach ($invD as $item)
                @php(array_push($subTotal,$item->qty*$item->unitPrice))
                @php($curCd = $item->curCd)
                <tr>
                    <td>{{$item->itemType}}</td>
                    <td>{{$item->description}}</td>
                    <td>{{$item->qty}}</td>
                    <td class="text-right">{{$item->curCd}} {{number_format($item->unitPrice)}}</td>
                    <td class="text-right">{{$item->curCd}} {{number_format($item->qty*$item->unitPrice)}}</td>
                </tr> 
                @endforeach
                <tr>
                    <td colspan="4" class="text-right">Sub total</td>
                    <td class="text-right">{{$curCd}} {{number_format(array_sum($subTotal))}}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">Tax</td>
                    <td class="text-right">{{$curCd}} {{number_format(10/100*array_sum($subTotal))}}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">Payments</td>
                    <td class="text-right">{{$curCd}} - {{number_format($invM->payments)}}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right font-weight-bold">Amount Due</td>
                    <td class="text-right">{{$curCd}} {{number_format(array_sum($subTotal)+(10/100*array_sum($subTotal))-$invM->payments)}}</td>
                </tr>
            </table>
        </div>
    </div>

   
@endsection
