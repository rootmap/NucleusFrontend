
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title') | Indian Garden Norrkoping</title>
  @yield('css')
  @include('admin.include.headerCss')
  @yield('extracss')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  @include('admin.include.top_nav')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.include.main_menu')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    {{-- @include('admin.include.breadcrumb') --}}

    <!-- Main content -->
    @yield('content')
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0
    </div>
    <strong>Copyright &copy; 2014-{{ date('Y') }} <a href="http://digimo.se/" target="_blank" >Digimo</a>.</strong> All rights
    reserved.
  </footer>

 
</div>
<!-- ./wrapper -->

@include('admin.include.footerJs')
@yield('js')
</body>
</html>
