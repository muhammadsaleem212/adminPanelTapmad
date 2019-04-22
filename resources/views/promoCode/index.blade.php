@extends('promoCode.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6 text-right">
          <a href="{{url('savePromoCode')}}" class="btn btn-primary">Add new Promo Code</a>
        </div>

    </div>
    <div id="app">
        @include('flash-message')


        @yield('content')
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{url('promoCode/search')}}">
         {{ csrf_field() }}
      </form>
      <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="promoCode: activate to sort column descending" aria-sort="ascending"> Promo Code</th>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="productCode: activate to sort column descending" aria-sort="ascending">Package Code</th>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="promoStartDate: activate to sort column descending" aria-sort="ascending"> Start Date</th>
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="promoExpireDate: activate to sort column descending" aria-sort="ascending"> Expiry Date</th>        
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="promoCodeCount: activate to sort column descending" aria-sort="ascending">Promo Count</th>        
              <th width="12%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="promoCodeCount: activate to sort column descending" aria-sort="ascending">Action</th>        
            </tr>
            </thead>
            <tbody>
            @foreach ($promoCode as $promo)
                <tr class="odd">
                  <td class="sorting_1">{{ $promo->PromoCode }}</td>
                  <td class="sorting_1">{{ $promo->PackageCode }}</td>
                  <td class="sorting_1">{{ $promo->PromoStartDate }}</td>
                  <td class="sorting_1">{{ $promo->PromoExpireDate }}</td>
                  <td class="sorting_1">{{ $promo->PromoCodeCount }}</td>
                  <td>
                    <form class="row" method="POST" action="{{ url ('promoCode/destroy',$promoCode[0]['PromoCodeId']) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ url ('promoCode/edit', ['id' => $promo->PromoCodeId]) }}" class="btn btn-warning col-sm-4 col-xs-5 btn-margin">
                        Update
                        </a>
                         <button type="submit" class="btn btn-danger col-sm-4 col-xs-5 btn-margin">
                          Delete
                        </button>
                    </form>
                  </td>
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