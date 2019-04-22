@extends('userScreens.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">List of user Screens</h3>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ url('saveUserScreens') }}">Add new user Screen</a>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ url('userScreens/search') }}">
         {{ csrf_field() }}
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable">
            <thead>
              <tr>
              <th width="25%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="userScreenID: activate to sort column descending" aria-sort="ascending"> Screen ID</th>
              <th width="25%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="userScreenName: activate to sort column descending" aria-sort="ascending">Screen Name</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($userScreen as $screens)
                <tr class="odd">
                  <td class="sorting_1">{{ $screens->userScreenName }}</td>
                  <td>
                    <form class="row" method="POST" action="{{ url('userScreens/destroy', ['id' => $screens->userScreenID]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ url('userScreens/edit', ['id' => $screens->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                        Update
                        </a>
                        @if ($screens->userScreenName != Auth::user()->username)
                         <button type="submit" class="btn btn-danger col-sm-3 col-xs-5 btn-margin">
                          Delete
                        </button>
                        @endif
                    </form>
                  </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection