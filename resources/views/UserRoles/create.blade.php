@extends('Admin.users.userRoles.base')
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new User Roles</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('userRoles/store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('userRoles') ? ' has-error' : '' }}">
                            <label for="userRoles" class="col-md-4 control-label">User Role</label>

                            <div class="col-md-6">
                                <input id="userRolesName" type="text" class="form-control" name="userRolesName" value="{{ old('userRolesName') }}" required autofocus>

                                @if ($errors->has('userRolesName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('userRolesName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
