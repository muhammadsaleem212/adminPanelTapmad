@extends('Admin/Users/userScreens/base')
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new User Screen</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('userScreens/store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('userScreenName') ? ' has-error' : '' }}">
                            <label for="userScreenName"  class="col-md-4 control-label">User Screen</label>

                            <div class="col-md-6">
                                <input id="userScreenName" type="text" class="form-control" name="userScreenName" value="{{ old('userScreenName') }}" required autofocus>

                                @if ($errors->has('userScreenName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('userScreenName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('screenDisplayName') ? ' has-error' : '' }}">
                            <label for="screenDisplayName"  class="col-md-4 control-label">Screen Display Name</label>

                            <div class="col-md-6">
                                <input id="screenDisplayName" type="text" class="form-control" name="screenDisplayName" value="{{ old('screenDisplayName') }}" required autofocus>

                                @if ($errors->has('screenDisplayName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('screenDisplayName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Screen Parent Module</label>
                            <div class="col-md-6">
                                <select class="form-control" name="userRoleID">
                                   <option value="0">Select Parent Module</option>
                                    @foreach ($userScreen as $screen)
                                        <option value="{{$screen->id}}">{{$screen->userScreenName}}</option>
                                    @endforeach
                                </select>
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
