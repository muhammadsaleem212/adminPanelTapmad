  <!-- Left side column. contains the logo and sidebar -->
  <?php
  use App\userScreen;
  $this->user= Auth::user();
  $userArray = $this->user->toArray();
  $userRoleID = $userArray['user_role_id'];
  //$userScreen = userScreen::getUsersScreens($userRoleID);
  $parentScreenJson = userScreen::getParentScreen($userRoleID);


  ?>
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
       
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name}}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
       
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
    
         
      <li><a href="Admin"><i class="fa fa-link"></i> <span>Dashboard</span></a></li>
    
      @foreach ($parentScreenJson as $screen)
      <?php    
       $user['screenID'] = $screen->screen_id;
       $user['userRoleID'] = $screen->user_role_id;
       $parentName = $screen->userScreenName;
       $childScreen = userScreen::getChildScreen($user);
       if(!$childScreen){ ?>
        <li class="active"><a href="Admin/{{$screen->userScreenName}}/{{ $screen->userScreenName }}"><i class="fa fa-link"></i> <span>{{ $screen->screenDisplayName  }}</span></a></li>
       <?php  }  else{
         ?>
           
           <li class="treeview">
           <a href="#" onclick="return false;">
             <i class="fa fa-table"></i> <span>{{ $screen->screenDisplayName }}</span>
             <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
             </span>
              </a>
           @foreach ($childScreen as $child)
           <ul class="treeview-menu">
           <li class="active"><a href="{{$child->userScreenName }}"><i class="fa fa-link"></i> <span>{{ $child->screenDisplayName }}</span></a></li>

          </ul>
        
         @endforeach
         </li>
         
      <?php  } ?>
      @endforeach
      </ul>
       
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>