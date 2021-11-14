@extends('index')
@section('title', 'Add Invoice')

@section('content')

    <!-- Content Row -->

    <div class="row mt-2">
        <div class="col-md-12 table-responsive">
            <form action="">
                @csrf
                <div class="form-group d-none after-save">
                    <label for="exampleInputEmail1">Invoice Number</label>
                    <input type="text" class="form-control" name="invId" placeholder="Invoice Number" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Subject</label>
                    <input type="text" maxlength="150" class="form-control" name="subject" placeholder="Subject" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Due Date</label>
                    <input type="date" class="form-control" name="dueDt" placeholder="Due Date" required>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Sender</label>
                            <select name="senderId" class="form-control" required>
                                <option value="">--Select Sender--</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{$vendor->vendId}}">{{$vendor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Receiver</label>
                            <select name="receiverId" class="form-control" required>
                                <option value="">--Select Receiver--</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{$vendor->vendId}}">{{$vendor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-success btn-save"><i class="fas fa-save"></i> Simpan</a>
            </form>
        </div>
    </div>

    <div class="row mt-2 d-none after-save">
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Item Code</label>
                        <input type="text" maxlength="150" class="form-control searchItem" name="itemId" placeholder="Item Code" required>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Item Name</label>
                        <input type="text" class="form-control searchItem" name="description" placeholder="Item Name" required>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Unit Price</label>
                        <input type="text" class="form-control" placeholder="Unit Price" name="unitPrice" required readonly>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">QTY</label>
                        <input type="number" class="form-control" placeholder="QTY" name="qty" required>
                    </div>
                </div>
            </div>
            <div class="col-12 shadow rounded bg-white d-none" style="position: absolute;z-index : 1">
                <li class="clone-item d-none"><a href="#" class="select-item "></a> </li>
                <ol id="listItem">
                    
                </ol>
            </div>
                <a href="#" class="btn btn-success btn-add"><i class="fas fa-plus"></i> Tambah</a>
        </div>
    </div>

    <div class="row mt-2 d-none after-save">
        <div class="col-md-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item No</th>
                        <th>Item Name</th>
                        <th>Unit Price</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    <tr class="tr-detail-clone d-none">
                        <td class="no"></td>
                        <td class="itemNo"></td>
                        <td class="itemNm"></td>
                        <td class="unitPrice"></td>
                        <td class="qty">
                            <div class="d-flex justify-content-start">
                                <input type="number" class="form-control qty-detail col-4" readonly>
                                <i class="fas fa-pencil text-primary after-edit"></i>
                                <i class="fas fa-check text-success d-none on-edit"></i>
                                <i class="fas fa-times text-danger d-none on-edit"></i>
                            </div>
                        </td>
                        <td class="amount"></td>
                        <td>
                            <i class="fas fa-trash btn-del"></i>
                        </td>
                    </tr>
                </thead>
                <tbody id="tbody-detail">
                    
                </tbody>
            </table>

        </div>
    </div>
    <script>
        $('.btn-save').click(function(){
            var subjecte =$('input[name="subject"]')
            var subject = subjecte.val()
            if(subject=='') {alert('Please Fill the Subject');subjecte.focus();}

            var dueDte =$('input[name="dueDt"]')
            var dueDt = dueDte.val()
            if(dueDt=='') {alert('Please Fill the Due Date');dueDte.focus();}

            var senderIde =$('select[name="senderId"]')
            var senderId = senderIde.val()
            if(senderId=='') {alert('Please Choose Sender');senderIde.focus();}

            var receiverIde =$('select[name="receiverId"]')
            var receiverId = receiverIde.val()
            if(receiverId=='') {alert('Please Choose Receiver');receiverIde.focus();}

            var params ={
                subject :subject,
                dueDt : dueDt,
                senderId : senderId,
                receiverId : receiverId
            }
            $.ajax({
                url : '/api/inv/add',
                method : 'post',
                data : params,
                success : function(d){
                    console.log(d)
                    if(!d.error){
                        $('input[name="invId"]').val(d.params.invId)
                        $('.btn-save').addClass('d-none')
                        $('.after-save').removeClass('d-none')
                    }
                },
                error : function(e){
                    console.log(e)
                }
            })
        })

        $('.searchItem').keyup(function(){
            var index = $(this).attr('name');
            $.get('/item/get?'+index+'='+$(this).val(),function(d){
                console.log(d)
                if(d.length > 0){
                    $('.rm-item').remove()
                    var html = d.map(function(e){
                        var clone = $('.clone-item').clone()
                        clone.addClass('rm-item').removeClass('clone-item').removeClass('d-none')
                        clone.find('a').text(e.itemId+' - '+e.itemType+' - '+e.description)
                        clone.find('a').attr('data-unitprice',e.unitPrice)
                        clone.find('a').attr('data-description',e.description)
                        clone.find('a').attr('data-itemid',e.itemId)
                        clone.find('a').attr('data-curcd',e.curCd)
                        return  clone
                    })
                    $('#listItem').html(html).promise().done(function(){
                        $(this).parent().removeClass('d-none')
                        $('.select-item').click(function(){
                            $('input[name="itemId"]').val($(this).data('itemid'))
                            $('input[name="description"]').val($(this).data('description'))
                            $('input[name="unitPrice"]').val($(this).data('curcd')+' '+$(this).data('unitprice'))
                            $('#listItem').parent().addClass('d-none')
                        })
                    })
                }
            })
        })

        $('.btn-add').click(function(){
            var itemIde =$('input[name="itemId"]')
            var itemId = itemIde.val()
            if(itemId=='') {alert('Invoice Number NotFound');itemIde.focus();}

            var qtye =$('input[name="qty"]')
            var qty = qtye.val()
            if(qty=='') {alert('Please Fill Qty');qtye.focus();}

            var params ={
                invId :$('input[name="invId"]').val(),
                itemId : itemId,
                qty:qty
            }
            $.ajax({
                url : '/api/inv/detail/add',
                method : 'post',
                data : params,
                success : function(d){
                    console.log(d)
                    if(!d.error){
                        getInvDetail({
                            invId : params.invId,
                        })

                    }
                },
                error : function(e){
                    console.log(e)
                }
            })
        })
    </script>
@endsection
