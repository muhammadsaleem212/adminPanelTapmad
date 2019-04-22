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
                <div class="panel-heading">Add new Dynamic Offers</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url ('Admin/Marketing/dynamicOffers/storeFormData') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <textarea id="description" type="input" class="form-control" name="description" value="{{ old('description') }}" required autofocus></textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('promoCode') ? ' has-error' : '' }}">
                            <label for="promoCode" class="col-md-4 control-label">Promo Code</label>

                            <div class="col-md-6">
                            <input id="promoCode" type="text" class="form-control" name="promoCode" value="{{ old('promoCode') }}" required autofocus>

                                @if ($errors->has('promoCode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('promoCode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('packageCode') ? ' has-error' : '' }}">
                            <label for="packageCode" class="col-md-4 control-label">Product ID</label>
                            <div class="col-md-6">
                        <select class="form-control" name="packageCode" id="packageCode" value="{{ old('packageCode') }}">
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
                        <label for="dateRange" class="col-md-4 control-label">Start and Expiry</label>

                            <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name = "datefilter" id="dateRange">
                            </div>
                           
                        </div>
                        <div class="form-group{{ $errors->has('imageURL') ? ' has-error' : '' }}">
                            <label for="promoCode" class="col-md-4 control-label">Image URL</label>

                            <div class="col-md-6">
                            <input id="imageURL" type="text" class="form-control" name="imageURL" value="{{ old('imageURL') }}" required autofocus>

                                @if ($errors->has('imageURL'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('imageURL') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('packageCode') ? ' has-error' : '' }}">
                            <label for="isBucket" class="col-md-4 control-label">Is Bucket</label>

                            <div class="col-md-6">
                            <input type="radio" name="isBucket" value="1"> Yes<br>
                            <input type="radio" name="isBucket" value="0"> No<br>
                                @if ($errors->has('isBucket'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('isBucket') }}</strong>
                                    </span>
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
