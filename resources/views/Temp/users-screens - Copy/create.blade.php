@extends('users-screens.base')
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new User Screen</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('users-screens.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('userScreens') ? ' has-error' : '' }}">
                            <label for="userScreens"  class="col-md-4 control-label">User Screen</label>

                            <div class="col-md-6">
                                <input id="userScreens" type="text" class="form-control" name="userScreens" value="{{ old('userScreen') }}" required autofocus>

                                @if ($errors->has('userScreen'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('userScreen') }}</strong>
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
