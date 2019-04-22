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
    
    $('input[id="datefilter"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('input[id="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  });

  $('input[id="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});


</script>
 <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
@extends('dynamicOffers.base')
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update Promo Code</div>
                <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('Admin/Marketing/promoCode/update',$promoCode[0]['PromoCodeId']) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Promo Code</label>

                            <div class="col-md-6">
                                <input id="userPromoCode" type="text" class="form-control" name="userPromoCode"  value="{{ $promoCode[0]['PromoCode'] }}" required autofocus>
                                @if ($errors->has('userPromoCode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('userPromoCode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('packageCode') ? ' has-error' : '' }}">
                            <label for="packageCode" class="col-md-4 control-label">Product ID</label>
                            <div class="col-md-6">
                        <select class="form-control" name="packageCode" id="packageCode" value="{{ $promoCode[0]['PackageCode'] }}">
                           <option value="">Select Package Code</option> 
                           <option value="1003">1003</option>
                            <option value="1005">1005</option>
                            <option value="1007">1007</option>
                        </select>                             
                                @if ($errors->has('packageCode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('packageCode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('dateRange') ? ' has-error' : '' }}">
                        <label for="startDate" class="col-md-4 control-label">Start Date</label>

                            <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name = "startDate" id="startDate">
                            </div>
                           
                        </div>
                        <div class="form-group{{ $errors->has('datePicker') ? ' has-error' : '' }}">
                        <label for="dateRange" class="col-md-4 control-label"> Expire Date</label>

                            <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name = "expireDate" id="datefilter">
                            </div>
                           
                        </div>
                        
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Total Number of Counts</label>

                            <div class="col-md-6">
                                <input id="promoCount" type="text" class="form-control" name="promoCount" value="{{ $promoCode[0]['PromoCodeCount'] }}" required autofocus>

                                @if ($errors->has('promoCount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('promoCount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="subscriptionDays" class="col-md-4 control-label">Total Subscription Days</label>

                            <div class="col-md-6">
                                <input id="subscriptionDays" type="text" class="form-control" name="subscriptionDays" value="{{ $promoCode[0]['SubscriptionDays'] }}" required autofocus>

                                @if ($errors->has('subscriptionDays'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subscriptionDays') }}</strong>
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
