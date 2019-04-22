<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$(function() {
	
    $('input[name="daterange"]:eq(0)').daterangepicker();
    
   
    $('input[name="daterange"]:eq(1)').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
            format: 'MM/DD/YYYY h:mm A'
        }
    });
    
   
    $('input[name="birthdate"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true
    }, 
    function(start, end, label) {
        var years = moment().diff(start, 'years');
        alert("You are " + years + " years old.");
    });
    
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

	
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        isCustomDate: function(){
        	return 'gewg';
        }
    }, cb);

    cb(start, end);
    
    $('input[name="datefilter"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  });

  $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});


</script>


@extends('dynamicOffers.base')
@section('action-content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new Promo Code</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url ('Admin/Marketing/promoCode/store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Promo Code</label>

                            <div class="col-md-6">
                                <input id="PromoCode" type="text" class="form-control" name="PromoCode" value="{{ old('PromoCode') }}" required autofocus>
                                @if ($errors->has('PromoCode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PromoCode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                
                        <div class="form-group{{ $errors->has('PackageCode') ? ' has-error' : '' }}">
                            <label for="PackageCode" class="col-md-4 control-label">Product ID</label>
                            <div class="col-md-6">
                        <select class="form-control" name="PackageCode" id="packageCode" value="{{ old('PackageCode') }}">
                           <option value="">Select Package Code</option> 
                           <option value="1005">1005</option>
                            <option value="1007">1007</option>
                            <option value="1009">1009</option>
                        </select>                             
                                @if ($errors->has('PackageCode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PackageCode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('dateRange') ? ' has-error' : '' }}">
                        <label for="dateRange" class="col-md-4 control-label">Start and Expiry</label>

                            <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name = "datefilter" id="dateRange">
                            </div>
                           
                        </div>
                        
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Total Number of Counts</label>

                            <div class="col-md-6">
                                <input id="promoCount" type="text" class="form-control" name="promoCount" value="{{ old('promoCount') }}" required autofocus>

                                @if ($errors->has('promoCount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('promoCount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('subscriptionDays') ? ' has-error' : '' }}">
                            <label for="subscriptionDays" class="col-md-4 control-label">Total Subscription Days</label>

                            <div class="col-md-6">
                                <input id="subscriptionDays" type="text" class="form-control" name="subscriptionDays" value="{{ old('subscriptionDays') }}" required autofocus>

                                @if(count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
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
