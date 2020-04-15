@if (session('status'))
    <div class="alert alert-success successPlace alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-check"></i> {{ session('status') }}</h5>  
    </div>
    <script type="text/javascript">
        setTimeout(function(){
            $('.successPlace').fadeOut('slow');
        }, 5000);
    </script>
    <?php 
    Session::forget('status');
    ?>
@endif

@if (session('success'))
    <div class="alert alert-success successPlace alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-check"></i> {{ session('success') }}</h5>  
    </div>
    <script type="text/javascript">
        setTimeout(function(){
            $('.successPlace').fadeOut('slow');
        }, 5000);
    </script>
    <?php 
    Session::forget('success');
    ?>
@endif

@if (session('error'))
    <div class="alert alert-danger allDanger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-ban"></i> Alert! {{ session('error') }}</h5>
          
    </div>
    <script type="text/javascript">
        setTimeout(function(){
            $('.allDanger').fadeOut('slow');
        }, 5000);
    </script>
    <?php 
    Session::forget('error');
    ?>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger allDanger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-ban"></i> Alert! </h5>
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    <script type="text/javascript">
        setTimeout(function(){
            $('.allDanger').fadeOut('slow');
        }, 10000);
    </script>
@endif