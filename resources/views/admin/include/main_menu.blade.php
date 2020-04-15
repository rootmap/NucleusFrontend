<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('dashboard')}}" class="brand-link">
      <img src="{{ url('admin/dist/img/AdminLTELogo.png') }}"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ url('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{url('dashboard')}}" class="nav-link {{ Request::path() == 'dashboard' ? 'active' : '' }}">
              <i class="nav-icon fas fa-igloo"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item has-treeview {{ in_array(Request::path(),array('slider','youtubevideogallery','features','intragtedsolutions','homevideos','joinsimplicity'))?'menu-open':'' }}">
            <a href="#" class="nav-link {{ in_array(Request::path(),array('slider','youtubevideogallery','features','intragtedsolutions','homevideos','joinsimplicity'))?'active':'' }}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home Page
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('slider')}}" class="nav-link {{ Request::path() == 'slider' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Slider</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('features')}}" class="nav-link {{ Request::path() == 'features' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Features</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('intragtedsolutions')}}" class="nav-link {{ Request::path() == 'intragtedsolutions' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Intregated Solution</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('homevideos')}}" class="nav-link {{ Request::path() == 'homevideos' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Video</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('youtubevideogallery')}}" class="nav-link {{ Request::path() == 'homevideos' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Video Gallery</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('joinsimplicity')}}" class="nav-link {{ Request::path() == 'joinsimplicity' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Join Simplicity</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview {{ in_array(Request::path(),array('package','package/create'))?'menu-open':'' }}">
            <a href="#" class="nav-link {{ in_array(Request::path(),array('package','package/create'))?'active':'' }}">
              <i class="nav-icon fas fa-book-open"></i>
              <p>
                Subscription Pricing
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('package/create')}}" class="nav-link {{ Request::path() == 'package/create' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New Package</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('package')}}" class="nav-link {{ Request::path() == 'package' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Package List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview {{ in_array(Request::path(),array('package','package/create'))?'menu-open':'' }}">
            <a href="#" class="nav-link {{ in_array(Request::path(),array('package','package/create'))?'active':'' }}">
              <i class="nav-icon fas fa-book-open"></i>
              <p>
                Hardware
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('hardwarepackage/create')}}" class="nav-link {{ Request::path() == 'package/create' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add New Hardware</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('hardwarepackage')}}" class="nav-link {{ Request::path() == 'package' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hardware List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('purchasehardware/create')}}" class="nav-link {{ Request::path() == 'package/create' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase New Hardware</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('purchasehardware')}}" class="nav-link {{ Request::path() == 'package' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Hardware List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview {{ in_array(Request::path(),array('retail','powerfulcapabilities','whatmakesbetter','couldboostprofitability','systemeasytouse','multipleemployeesaccess'))?'menu-open':'' }}">
            <a href="#" class="nav-link {{ in_array(Request::path(),array('retail','powerfulcapabilities','whatmakesbetter','couldboostprofitability','systemeasytouse','multipleemployeesaccess'))?'active':'' }}">
              <i class="nav-icon fas fa-utensils"></i>
              <p>
                Question
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('retail')}}" class="nav-link {{ Request::path() == 'retail' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Retail</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('powerfulcapabilities')}}" class="nav-link {{ Request::path() == 'powerfulcapabilities' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Powerful Capabilities</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('whatmakesbetter')}}" class="nav-link {{ Request::path() == 'whatmakesbetter' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>What Makes Better </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('couldboostprofitability')}}" class="nav-link {{ Request::path() == 'couldboostprofitability' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Could Boost Profitability </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('systemeasytouse')}}" class="nav-link {{ Request::path() == 'systemeasytouse' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>System Easy to Use </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('multipleemployeesaccess')}}" class="nav-link {{ Request::path() == 'multipleemployeesaccess' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Multiple Employees Access</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview {{ in_array(Request::path(),array('businesspossystem','coresoftwarecomponents','corehardwarecomponents'))?'menu-open':'' }}">
            <a href="#" class="nav-link {{ in_array(Request::path(),array('businesspossystem','coresoftwarecomponents','corehardwarecomponents'))?'active':'' }}">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Business POS System
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('businesspossystem')}}" class="nav-link {{ Request::path() == 'businesspossystem' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Modify Business POS </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('coresoftwarecomponents')}}" class="nav-link {{ Request::path() == 'coresoftwarecomponents' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Core Software Components</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('corehardwarecomponents')}}" class="nav-link {{ Request::path() == 'corehardwarecomponents' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Core Hardware Components</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview {{ in_array(Request::path(),array('simplecashregister'))?'menu-open':'' }}">
            <a href="{{url('simplecashregister')}}" class="nav-link {{ in_array(Request::path(),array('simplecashregister'))?'active':'' }}">
              <i class="nav-icon fas fa-images"></i>
              <p>
                Simple Cash Register
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview {{ in_array(Request::path(),array('retailstore','keyfeature','otherfeature'))?'menu-open':'' }}">
            <a href="#" class="nav-link {{ in_array(Request::path(),array('retailstore','keyfeature','otherfeature'))?'active':'' }}">
              <i class="nav-icon fas fa-images"></i>
              <p>
                Retail Store Menu
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('retailstore')}}" class="nav-link {{ Request::path() == 'retailstore' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Modify Retail Store</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('keyfeature')}}" class="nav-link {{ Request::path() == 'keyfeature' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Key Feature</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('otherfeature')}}" class="nav-link {{ Request::path() == 'otherfeature' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Other Feature</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item has-treeview {{ in_array(Request::path(),array('blogs','blogcomment'))?'menu-open':'' }}">
            <a href="#" class="nav-link {{ in_array(Request::path(),array('blogs','blogcomment'))?'active':'' }}">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Blog
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('blogs')}}" class="nav-link {{ Request::path() == 'blogs' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blog Post</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('blogcomment')}}" class="nav-link {{ Request::path() == 'blogcomment' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blog Comment</p>
                </a>
              </li>
              
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{url('contactusrequest')}}" class="nav-link {{ Request::path() == 'contactusrequest' ? 'active' : '' }}">
              <i class="nav-icon fas fa-phone-square-alt"></i>
              <p>Contact</p>
            </a>
          </li>
          <li class="nav-item has-treeview {{ in_array(Request::path(),array('sitesetting','pagesetting','cardpointestoresetting','websitesettings/create'))?'menu-open':'' }}">
            <a href="#" class="nav-link {{ in_array(Request::path(),array('sitesetting','pagesetting','cardpointestoresetting','websitesettings/create'))?'active':'' }}">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Setting
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('sitesetting')}}" class="nav-link {{ Request::path() == 'sitesetting' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Site Setting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('pagesetting')}}" class="nav-link {{ Request::path() == 'pagesetting' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Page Setting</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="{{url('cardpointestoresetting')}}" class="nav-link {{ Request::path() == 'cardpointestoresetting' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cardpointe Store Setting</p>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

    {{-- ============================================ --}}
    <div class="side-bar-bottom">
        <ul class="list-unstyled">
          <li class="list-inline-item" data-toggle="tooltip" data-html="true" title="Edit Profile"><a
              href="#"><i class="fas fa-cog"></i></a></li>
          <li class="list-inline-item" data-toggle="tooltip" data-html="true" title="Change Password"><a
              href="#"><i class="fas fa-key"></i></li>
          <li class="list-inline-item" data-toggle="tooltip" data-html="true" title="Lockscreen"><a
              href="#"><i class="fas fa-unlock"></i></a></li>
          <li class="list-inline-item" data-toggle="tooltip" data-html="true" title="Logout">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"><i class="fas fa-power-off"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
          </li>
        </ul>
      </div><!-- End side-bar-bottom -->
  </aside>

  <style type="text/css">
    .side-bar-bottom {
      width: 100%;
      height: 35px;
      background-color: #343a40;
      position: -webkit-sticky;
      position: sticky;
      bottom: 0px;
      margin-top: 93%;
      color: #cccccc;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      border-top: 2px solid #444a50;
      padding-top: 25px;
      /*-webkit-box-shadow: 0px 2px 5px 5px black;
      box-shadow: 0px 2px 5px 5px black;*/
  }
  .side-bar-bottom ul li a i{
    color: #fff;
    padding: 10px;
  }
  </style>