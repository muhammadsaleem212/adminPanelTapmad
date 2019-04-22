@extends('userScreens.base')
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update user Screen</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('Admin/Users/userScreens/update', ['id' => $userScreen->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('userScreen') ? ' has-error' : '' }}">
                            <label for="userScreen" class="col-md-4 control-label">User Screen Name</label>

                            <div class="col-md-6">
                                <input id="userScreen" type="text" class="form-control" name="userScreen" value="{{ $userScreen->userScreenName }}" required autofocus>

                                @if ($errors->has('userScreenName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('userScreenName') }}</strong>
                                    </span>
                                @endif
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
