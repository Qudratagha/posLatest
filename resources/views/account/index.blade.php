@extends('layouts.admin')
@section('title', 'Account Index')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-user-graduate"></i> Accounts
            </h3>
            <div class="card-actions">
                <a href="{{route('account.create')}}" class="btn btn-primary d-none d-sm-inline-block">
                    <i class="fas fa-plus"></i> Add Account
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover datatable display">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Account Name</th>
                    <th>Account Type</th>
                    <th>Account Number</th>
                    <th>Balance</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accounts  as $account)
                    <tr>
                        <td>{{ $account->accountID }}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->type }}</td>
                        <td>{{ $account->accountNumber }}</td>
                        <td>{{getAccountBalance($account->accountID)}}</td>
                        <td>
                            <a href="{{ route('account.show', $account->accountID) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="ps-1 pe-1" href="{{ route('account.edit', $account->accountID) }}">
                                <i class="text-yellow fa fa-edit"></i>
                            </a>
                            <form action="{{ route('account.destroy', $account->accountID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <a class="ps-1 pe-1" href="javascript:void(0);" onclick="$(this).closest('form').submit();">
                                    <i class="text-red fa fa-trash"></i>
                                </a>
                            </form>
                            <a class="ps-1 pe-1" href="{{ url('/account/statement/') }}/{{ $account->accountID }}">
                                <i class="fa-solid fa-arrow-trend-up"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection

