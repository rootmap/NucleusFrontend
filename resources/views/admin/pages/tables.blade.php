@extends('admin.layout.master')
@section('title','Table')
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        {{-- <h1>General Form</h1> --}}
        <a class="btn btn-primary" href="{{url('test/create')}}">Add New <i class="fas fa-plus"></i></a>
      </div>
      {{-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">General Form</li>
        </ol>
      </div> --}}
    </div>
  </div><!-- /.container-fluid -->
</section>
<section class="content">
  <div class="row">
    <div class="col-12">
      <!-- /.card -->
      <div class="card">
        <div class="card-header">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3 class="card-title">DataTable with default features</h3>
            </div>
            <div class="col-sm-6">
              <div class="col text-right">
                <div class="tools-btns">
                    <a href="{{url('test/export/pdf')}}"><i class="fas fa-file-pdf" data-toggle="tooltip" data-html="true"title="Pdf"></i></a>
                    <a href="{{url('test/export/excel')}}"><i class="fas fa-file-excel" data-toggle="tooltip" data-html="true"title="Excel"></i></a>
                </div><!-- End tool-btns-->
            </div><!-- End text-right-->
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Rendering engine</th>
              <th>Browser</th>
              <th>Platform(s)</th>
              <th>Engine version</th>
              <th>CSS grade</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>Trident</td>
              <td>Internet
                Explorer 4.0
              </td>
              <td>Win 95+</td>
              <td> 4</td>
              <td>X</td>
              <td>
                  <a href=""><i class="fas fa-edit"></i></a>
                  <a href=""><i class="fas fa-trash-alt"></i></a>
              </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
              <th>Rendering engine</th>
              <th>Browser</th>
              <th>Platform(s)</th>
              <th>Engine version</th>
              <th>CSS grade</th>
            </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

@endsection
@section('css')
  <link rel="stylesheet" href="{{ url('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
@endsection
@section('js')

  <!-- DataTables -->
<script src="{{ url('admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ url('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('admin/dist/js/demo.js') }}"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
@endsection