@extends('Channels.base')
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
        <div class="col-sm-6 text-right">
          <a href="{{url('ChannelController/create')}}" class="btn btn-primary">Add Channel Questions</a>
        </div>

    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      
      <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="channelName: activate to sort column descending" aria-sort="ascending"> Channel Name</th>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="categoryName: activate to sort column descending" aria-sort="ascending"> Channel Category Name</th>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="channelIsOnline: activate to sort column descending" aria-sort="ascending">Channel IsOnline</th>      
            </tr>
            </thead>
            <tbody>
            @foreach ($channels as $channel)
                <tr class="odd">
                  <td class="sorting_1">{{ $channel->ChannelName }}</td>
                  <td class="sorting_1">{{ $channel->ChannelCategoryName }}</td>
                  <td class="sorting_1">{{ $channel->ChannelIsOnline }}</td>
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