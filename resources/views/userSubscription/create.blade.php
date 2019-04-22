

@extends('userSubscription.base')
@section('action-content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new Subscription</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('userSubscription/store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('promoCode') ? ' has-error' : '' }}">
                            <label for="subscriptionNumber" class="col-md-4 control-label">Enter Number</label>

                            <div class="col-md-6">
                            <input type="number" id="subscriptionNumber"  class="form-control" name="subscriptionNumber" value="{{ old('subscriptionNumber') }}" required autofocus>

                                @if ($errors->has('subscriptionNumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subscriptionNumber') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('packageCode') ? ' has-error' : '' }}">
                            <label for="packageCode" class="col-md-4 control-label">Product ID</label>
                            <div class="col-md-6">
                        <select class="form-control" name="packageCode" id="packageCode" value="{{ old('packageCode') }}">
                           <option value="">Select Package Code</option> 
                           <option  value="1005">1005</option>
                            <option value="1007">1007</option>
                            <option value="1009">1009</option>
                        </select>                             
                                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
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
