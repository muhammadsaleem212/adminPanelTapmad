@extends('dynamicOffers.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6 text-right">
          <a href="{{url('/Admin/Marketing/userSubscription/create')}}" class="btn btn-primary">Add Subscription by Number</a>
          <a href="{{url('/Admin/Marketing/userSubscription/create')}}" class="btn btn-success">Add Subscription by ACR</a>
        </div>

    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
  <div id="app">
        @include('flash-message')


        @yield('content')
    </div>
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{url('/Admin/Marketing/userSubscription/search')}}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Search'])
          @component('layouts.two-cols-search-row', ['items' => ['Mobile Number'],
          'oldVals' => [isset($searchingVals) ? $searchingVals['UserUsername']: '']])
          @endcomponent
        @endcomponent
      </form>
      <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
            @if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}"> 
    {!! session('message.content') !!}
    </div>
@endif
              <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="userRoleID: activate to sort column descending" aria-sort="ascending"> Mobile Num</th>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="userRoleID: activate to sort column descending" aria-sort="ascending"> User ID</th>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="userScreenName: activate to sort column descending" aria-sort="ascending">Package Name</th>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="userScreenName: activate to sort column descending" aria-sort="ascending">Package Code</th>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="userScreenName: activate to sort column descending" aria-sort="ascending">Expire Date</th>        
            </tr>
            </thead>
            <tbody>
            @foreach ($userSubscription as $subscription)
                <tr class="odd">
                  <td class="sorting_1">{{ $subscription->UserUsername }}</td>
                  <td class="sorting_1">{{ $subscription->UserSubscriptionUserId }}</td>
                  <td class="sorting_1">{{ $subscription->PackageName }}</td>
                  <td class="sorting_1">{{ $subscription->UserPackageCode }}</td>
                  <td class="sorting_1">{{ $subscription->UserSubscriptionExpiryDate }}</td>
              </tr>
            @endforeach
            </tbody>
               
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