<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('user.file.index')}}"
                               class="nav-link {{strpos(url()->current(), 'file') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>File</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user.report.index')}}"
                               class="nav-link {{ strpos(url()->current(), 'report') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" >
                                {{ csrf_field() }}
                                <button class="nav-link">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
