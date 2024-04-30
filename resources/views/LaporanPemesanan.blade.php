3<!DOCTYPE html>
<html lang="en">
<head>
  @include("Header.Header")
  <title>Pembelian Produk</title>
  @vite(['resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  @include("Header.Navbar")
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Pemesanan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item active">Laporan Pemesanan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->
    
    <!-- Vue app container -->
    <div id="app">
      <router-view></router-view>
    </div>
  </div><!-- /.content-wrapper -->
  
  @include("Header.Footer")
</body>
</html>
