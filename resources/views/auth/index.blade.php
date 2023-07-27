@extends('layouts.admin')
@section('title', 'Purchase Index')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-user-graduate"></i> Users
            </h3>
            <div class="card-actions">
                <a href="#" class="btn btn-primary d-none d-sm-inline-block">
                    <i class="fas fa-plus"></i> Add User
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover datatable display">
                <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <td>{{ $key+1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td></td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('more-script')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection



