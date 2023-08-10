@extends('layouts.admin')
@section('title', 'Account Index')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-user-graduate"></i> Transfers
            </h3>
            <div class="card-actions">
                <a href="{{url('/account/transfer/create')}}" class="btn btn-primary d-none d-sm-inline-block">
                    <i class="fas fa-plus"></i> Create
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover datatable display">
                <thead>
                <tr>
                    <th>#</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                    <th>Notes</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data  as $key=>$item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->accountFrom->name}}</td>
                        <td>{{ $item->accountTo->name}}</td>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->amount }}</td>

                        <td>
                            @can('Delete Transfer')
                            <a class="ps-1 pe-1" href="{{ url('/account/transfer/delete/') }}/{{$item->refID}}">
                                <i class="text-danger fa fa-trash"></i>
                            </a>
                            @endcan

                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection

