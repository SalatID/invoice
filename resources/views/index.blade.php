<html>
    <title>@yield('title')</title>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </head>
    <body>
        <section class="p-3">
            <div class="container">
                <div class="col-md-12">
                    <div class="card shadow rounded">
                        <div class="card-body">
                          <h5 class="card-title">@yield('title')</h5>
                          <div class="card-body">
                            @yield('content')
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <script>
        function getInvDetail(params){
            $.ajax({
                url : '/api/inv/get',
                method : 'post',
                data : params,
                success : function(d){
                    console.log(d)
                    if(!d.error){
                        var i =1
                        html = d.params.map(function(e){
                            var clone = $('.tr-detail-clone').clone()
                            clone.addClass('tr-clone').removeClass('d-none').removeClass('tr-detail-clone')
                            clone.find('.no').text(i++)
                            clone.find('.itemNm').text(e.description)
                            clone.find('.itemNo').text(e.itemId)
                            clone.find('.unitPrice').text(e.curCd+' '+e.unitPrice)
                            clone.find('.qty-detail').val(e.qty)
                            clone.find('.qty-detail').attr('data-invid',e.invId)
                            clone.find('.qty-detail').attr('data-seq',e.seq)
                            clone.find('.qty-detail').attr('data-itemid',e.itemId)
                            clone.find('.btn-del').attr('data-invid',e.invId)
                            clone.find('.btn-del').attr('data-seq',e.seq)
                            clone.find('.btn-del').attr('data-itemid',e.itemId)
                            clone.find('.amount').text((e.qty*e.unitPrice))
                            return clone
                        })
                        $('#tbody-detail').html(html).promise().done(function(){
                            var oldVal;
                            var newVal;
                            $('.after-edit').click(function(){
                                oldVal = $(this).parent().find('.qty-detail').val()
                                newVal = oldVal
                                $(this).parent().find('.qty-detail').attr('readonly',false)
                                $(this).parent().find('.on-edit').removeClass('d-none')
                                $(this).addClass('d-none')
                            })
                            $('.on-edit').click(function(){
                                if($(this).hasClass('text-success')){
                                    params = {
                                        qty:newVal,
                                        invId:$(this).parent().find('.qty-detail').data('invid'),
                                        itemId:$(this).parent().find('.qty-detail').data('itemid'),
                                    }
                                    $.ajax({
                                        url : '/api/inv/detail/qty/update',
                                        method : 'put',
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
                                    $(this).parent().find('.qty-detail').val(newVal)
                                } else {
                                    $(this).parent().find('.qty-detail').val(oldVal)
                                }
                                $(this).parent().find('.on-edit').addClass('d-none')
                                $(this).parent().find('.after-edit').removeClass('d-none')
                                $(this).parent().find('.qty-detail').attr('readonly',true)
                            })
                            $('.qty-detail').change(function(){
                                newVal = $(this).val()
                            })
                            $('.btn-del').click(function(){
                                if(confirm("Delete Item?")){
                                    params = {
                                        invId:$(this).data('invid'),
                                        itemId:$(this).data('itemid'),
                                    }
                                    $.ajax({
                                        url : '/api/inv/detail/delete',
                                        method : 'delete',
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
                                }
                            })
                        })
                    }
                },
                error : function(e){
                    console.log(e)
                }
            })
        }
    </script>
</html>