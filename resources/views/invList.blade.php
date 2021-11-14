@extends('index')
@section('title','Invoice List')
 
@section('content')

<!-- Content Row -->

<div class="d-flex justify-content-start">
    <a class="btn btn-success" href="/inv/add" ><i class="fas fa-plus"></i> Add Invoice</a>
</div>
<div class="row mt-2">
    <div class="col-md-12 table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Invoice Number</th>
                    <th class="text-center">Subject</th>
                    <th class="text-center">Sender</th>
                    <th class="text-center">Receiver</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
                <tr class="tr-inv-clone d-none">
                    <td class="text-center no"></td>
                    <td class="invId"></td>
                    <td class="subject"></td>
                    <td class="senderNm"></td>
                    <td class="receiverNm"></td>
                    <td class="amount"></td>
                    <td class="invStatus"></td>
                    <td class="text-center">
                        <div class="d-flex justify-content-between">
                            <a href="#" class="btn btn-link btn-edit"><i class="fas fa-pencil"></i> </a>
                            <a href="#" target="_blank" class="btn btn-link btn-pdf"><i class="fas fa-list"></i> </a>
                            <a href="#" class="btn btn-link btn-del"><i class="fas fa-trash"></i> </a>
                        </div>
                    </td>
                </tr>
            </thead>
            <tbody id="tbody-inv">
            </tbody>
        </table>
    </div>
</div>
<script>
    $.get('/api/inv/get',function(e){
        console.log(e)
        if(!e.error){
            i=1
            var html = e.params.map(function(d){
                var clone = $('.tr-inv-clone').clone()
                clone.removeClass('d-none')
                clone.find('.no').text(i++)
                clone.find('.invId').text(d.invId)
                clone.find('.subject').text(d.subject)
                clone.find('.senderNm').text(d.senderNm)
                clone.find('.receiverNm').text(d.receiverNm)
                clone.find('.invStatus').text(d.invStatus)
                clone.find('.amount').text(number_format((10/100*d.amount)+d.amount))
                clone.find('.btn-edit').attr('href','/inv/edit?invId='+d.invId)
                clone.find('.btn-pdf').attr('href','/inv/detail?invId='+d.invId)
                clone.find('.btn-del').attr('data-invid',d.invId)
                return clone
            })
            $('#tbody-inv').html(html).promise().done(function(){
                $('.btn-del').click(function(){
                    if(confirm("Delete Invoice?")){
                        params = {
                            invId:$(this).data('invid'),
                        }
                        $.ajax({
                            url : '/api/inv/delete',
                            method : 'delete',
                            data : params,
                            success : function(d){
                                console.log(d)
                                if(!d.error){
                                    location.reload()

                                }
                            },
                            error : function(e){
                                console.log(e)
                            }
                        })
                    }
                })
            })
        }
    })
</script>
@endsection