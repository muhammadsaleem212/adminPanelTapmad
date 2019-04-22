@extends('userPermissions.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new User Permission</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('userPermissions.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-4 control-label">User Roles</label>
                            <div class="col-md-6">
                                <select class="form-control" name="userRoleID">
                                    @foreach ($role as $roles)
                                        <option value="{{$roles->id}}">{{$roles->userRolesName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="clearfix row">
                        <div class = "clearfix col-sm-12">
                        <div class="box-body bg-white">
                        <div class="clearfix row">
                        @foreach ($screen as $screens)
                        <div class="col-sm-3">
                        <div name="userScreenID" class="formSubHeaderRow" align="left">
                        <label class="bold "> {{$screens->userScreenName}}</label>
                        <br><br><span><input type="checkbox" name="userScreenID[]" value = {{$screens->id}}> Screen Rights</span>
                        </div>
                        </div>
                        @endforeach
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
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
