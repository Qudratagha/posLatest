@extends('layouts.admin')
@section('title', 'Account Create')
@section('content')
    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h4 class="card-title fw-semibold">
                <i class="fas fa-users-cog"></i> Create Transfer
            </h4>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ url('/account/depositWithdrawals/store') }}" method="POST">
                @csrf

                <div class="form-group row mt-2">
                    <label for="type" class=" form-label col-sm-4 col-md-2 col-lg-2  col-form-label">From</label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <select name="from" class="form-select productField">
                            @foreach ($accounts as $account)
                                <option value="{{$account->accountID}}">{{$account->name}} ({{$account->type}})</option>
                            @endforeach
                        </select>
                    </div>
                    @error('from')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group row mt-2">
                    <label for="type" class=" form-label col-sm-4 col-md-2 col-lg-2  col-form-label">From</label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <select name="from" class="form-select productField">
                            @foreach ($accounts as $account)
                                <option value="{{$account->accountID}}">{{$account->name}} ({{$account->type}})</option>
                            @endforeach
                        </select>
                    </div>
                    @error('from')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group row mt-2">
                    <label for="type" class=" form-label col-sm-4 col-md-2 col-lg-2  col-form-label">Payment Type</label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <select name="type" class="form-select">
                            <option>Deposit</option>
                            <option>Withdraw</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <label for="initialBalance" class=" form-label col-sm-4 col-md-2 col-lg-2  col-form-label">Amount: </label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="number" name="amount" class="form-control" value="{{ old('amount') }}" value="0" placeholder="Enter Amount">
                    </div>
                    @error('amount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
                <div class="form-group row mt-2">
                    <label for="date" class=" form-label col-sm-4 col-md-2 col-lg-2  col-form-label">Date: </label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" placeholder="Date">
                    </div>
                    @error('date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>

                <div class="form-group row mt-2">
                    <label for="notes" class=" form-label col-sm-4 col-md-2 col-lg-2  col-form-label">Notes: </label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <textarea type="text" name="notes" class="form-control" placeholder="Address">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <div class="offset-2">
                        <input class="btn btn-primary" type="submit" value="Save">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('more-script')
    <script>
        $(document).ready(function() {
            new TomSelect(".productField",{
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
                });
        });
    </script>
@endsection
