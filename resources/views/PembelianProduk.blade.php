<!DOCTYPE html>
<html lang="en">
<head>
  @include("Header.Header")
  <title>Pembelian Produk</title>
  @vite(['resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  @include("Header.Navbar")
  @include("Header.Bar")
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pembelian Produk</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item active">Pembelian Produk</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div id="app">
      <router-view></router-view>
    </div>
  </div>
  @include("Header.Footer")
</body>
</html>
