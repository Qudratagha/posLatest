@extends('layouts.admin')
@section('title', 'Unit Show')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="fas fa-user-graduate"></i> Edit Role
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ url('/role/update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $role->id }}">
                    <div class="row">
                        <div class="col-12 mt-2">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $role->name }}" placeholder="Change Name">
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-success">Update Role</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="fas fa-user-graduate"></i> Assign Permissions
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 mt-2">
                <form method="post" action="{{ url('/role/updatePermissions') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $role->id }}">
                    <div class="row">
                    @foreach ($permissions as $permission)
                    <div class="col-3">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->name }}"
                                {{ $role->permissions->contains($permission) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="{{ $permission->name }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                        </div>
                    @endforeach
                </div>
                    <button type="submit" class="btn btn-primary mt-3">Update Permissions</button>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection
