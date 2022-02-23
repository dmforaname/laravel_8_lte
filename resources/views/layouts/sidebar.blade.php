    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="/admin" class="nav-link">
              <i class="nav-icon fa fa-building"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('user-manager.index')}}" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>
                User Manager
              </p>
            </a>
          </li>
         
          <li class="nav-item">

            <a class="nav-link" href="javascript:void(0)" onclick="event.preventDefault(); clickLogout();">
                <i class="nav-icon fa fa-power-off"></i>
                <p>
                  {{ __('Logout') }}
                </p>                     
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
    
          </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->