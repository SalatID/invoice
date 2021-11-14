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
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">#</td>
                    <td>Invoice Number</td>
                    <td>Subject</td>
                    <td>Sender</td>
                    <td>Receiver</td>
                    <td>Amount</td>
                    <td class="text-center">
                        <a href="#" class="btn btn-link"><i class="fas fa-pencil"></i> </a>
                        <a href="#" class="btn btn-link"><i class="fas fa-file-pdf"></i> </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection