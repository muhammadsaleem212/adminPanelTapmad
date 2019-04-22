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
@extends('TransactionFailed.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
  <div id="app">
        @include('flash-message')
        @yield('content')
    </div>
    <div class="row">
    <div class="col-sm-6">
        </div>
        

    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6">      
        </div>
        <div class="col-sm-6"></div>
        
      </div>
      <form method="POST" action="{{url('TransactionFailed/index')}}" enctype="multipart/form-data">
        
         {{ csrf_field() }}
        
         @component('layouts.search', ['title' => 'Search'])
         <div class = "col-md-5">
         <label class="col-md-4 control-label">Failed Messages</label>
                            <div class="col-md-6">
                                <select class="form-control" name="PaymentMessage">
                                    @foreach ($FailedTransactionMessage as $message)
                                        <option value="{{$message->UserPaymentMessage}}">{{$message->UserPaymentMessage}}</option>
                                    @endforeach
                                </select>
                            </div>
        </div>
          @component('layouts.two-cols-search-row', ['items' => ['Date Range'],
          'oldVals' => [isset($searchingVals) ? $searchingVals['datefilter']: '']]),
          @endcomponent
        @endcomponent
        
        <div class="col-md-12 text-right">
          <!-- <button class="btn btn-success " name = "Export" value = "1">Export</button> -->
          <button class="btn btn-success text-right" name = "Export" value = "1">Export</button>
        </div>
       
      <section class="content">
      <div class="row">
        <div class="col-xs-12">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
           
       </div>
                        </div>
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="channelName: activate to sort column descending" aria-sort="ascending"> Log Platform</th>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="categoryName: activate to sort column descending" aria-sort="ascending"> User ID</th>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="channelIsOnline: activate to sort column descending" aria-sort="ascending">Product ID</th> 
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="channelIsOnline: activate to sort column descending" aria-sort="ascending">Operator ID</th>      
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="channelIsOnline: activate to sort column descending" aria-sort="ascending">Mobile No</th>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="channelIsOnline: activate to sort column descending" aria-sort="ascending">Start Date</th>         
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="channelIsOnline: activate to sort column descending" aria-sort="ascending">Log Message</th>         
     
            </tr>
            </thead>
            <tbody>
            @foreach ($TransactionFailed as $Failed)
                <tr class="odd">
                  <td class="sorting_1">{{ $Failed->UserPaymentPlatform }}</td>
                  <td class="sorting_1">{{ $Failed->UserPaymentUserName }}</td>
                  <td class="sorting_1">{{ $Failed->UserPaymentPackageType }}</td>
                  <td class="sorting_1">{{ $Failed->UserPaymentOperatorID }}</td>
                  <td class="sorting_1">{{ $Failed->UserPaymentMobileNumber }}</td>
                  <td class="sorting_1">{{ $Failed->UserPaymentStartDate }}</td>
                  <td class="sorting_1">{{ $Failed->UserPaymentMessage }}</td>
              </tr>
            @endforeach
            </tbody>
            </form>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection

<!-- jQuery 3 -->
<script src="/laravelAdminBackup/public/bower_components/adminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/laravelAdminBackup/public/bower_components/adminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/laravelAdminBackup/public/bower_components/adminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/laravelAdminBackup/public/bower_components/adminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/laravelAdminBackup/public/bower_components/adminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="/laravelAdminBackup/public/bower_components/adminLTE/bower_components/fastclick/lib/fastclick.js"></script>
<script src="/laravelAdminBackup/public/bower_components/adminLTE/dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>