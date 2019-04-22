@extends('userPermissions.base')
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update User Permission</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('userPermissions.update', ['id' => $userPermission->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-md-4 control-label">User Screen</label>
                            <div class="col-md-6">
                                <select class="form-control" name="userScreenID">
                                    @foreach ($userScreen as $screen)
                                        <option value="{{$screen->id}}" {{$screen->id == $userPermission->screen_id ? 'selected' : ''}}>{{$screen->userScreenName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                          <div class="form-group">
                            <label class="col-md-4 control-label">User Role</label>
                            <div class="col-md-6">
                                <select class="form-control" name="userRoleID">
                                    @foreach ($roles as $role)
                                        <option value="{{$role->id}}" {{$role->id == $userPermission->user_role_id ? 'selected' : ''}}>{{$role->userRolesName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
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
