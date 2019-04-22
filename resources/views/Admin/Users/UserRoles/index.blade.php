@extends('Admin.users.userRoles.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">List of user Roles</h3>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ url('userRoles/create') }}">Add new user Role</a>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ url('userRoles/search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Search'])
          @component('layouts.two-cols-search-row', ['items' => ['Role'],
          'oldVals' => [isset($searchingVals) ? $searchingVals['userRole']: '']])
          @endcomponent
        @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable">
            <thead>
              <tr>
              <th width="10%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="userRoleID: activate to sort column descending" aria-sort="ascending"> Role ID</th>
              <th width="10%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="userRoleName: activate to sort column descending" aria-sort="ascending">Role Name</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($userRole as $roles)
                <tr class="odd">
                  <td class="sorting_1">{{ $roles->userRolesName }}</td>
                  <td>
                    <form class="row" method="POST" action="{{ url('userRoles/destroy', ['id' => $roles->userRolesID]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ url('Admin/Users/userRoles/edit', ['id' => $roles->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                        Update
                        </a>
                        @if ($roles->userRoleName != Auth::user()->username)
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