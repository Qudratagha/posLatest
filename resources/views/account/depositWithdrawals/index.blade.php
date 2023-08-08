@extends('layouts.admin')
@section('title', 'Account Index')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-user-graduate"></i> Deposit / Withdrawals
            </h3>
            <div class="card-actions">
                <a href="{{url('/account/depositWithdrawals/create')}}" class="btn btn-primary d-none d-sm-inline-block">
                    <i class="fas fa-plus"></i> Create
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover datatable display">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Account</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Notes</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data  as $key=>$item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->account->name}}</td>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->paymentType }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->amount }}</td>

                        <td>
                            <a class="ps-1 pe-1" href="{{ url('/account/depositWithdrawals/delete/') }}/{{$item->refID}}">
                                <i class="text-danger fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection

