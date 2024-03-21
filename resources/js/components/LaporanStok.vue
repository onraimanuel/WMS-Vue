<template>
        <section class="content">
          <div class="container-fluid">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Stok</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Produk</th>
                      <th>Stok</th>
                      <th>Kategori Produk</th>
                      <th>Spesifikasi Produk</th>
                      <th>Tanggal Masuk</th>
                      <th>Tanggal Expired</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in dataStok" :key="index">
                      <td>{{ index + 1 }}</td>
                      <td>{{ item.namaProduk }}</td>
                      <td>{{ item.stok }}</td>
                      <td>{{ item.kategoriProduk }}</td>
                      <td>{{ item.spesifikasiProduk }}</td>
                      <td>{{ item.tanggalMasuk }}</td>
                      <td>{{ item.tanggalExpired }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
  </template>
  
  <script>
  export default {
    data() {
      return {
        dataStok: [
          { namaProduk: 'aaaa', stok: 2, kategoriProduk: 'PCS', spesifikasiProduk: 'Keripik', tanggalMasuk: '20 Maret 2023', tanggalExpired: '20 April 2023' },
          { namaProduk: 'aaaa', stok: 2, kategoriProduk: 'PCS', spesifikasiProduk: 'Keripik', tanggalMasuk: '20 Maret 2023', tanggalExpired: '20 April 2023' },
          { namaProduk: 'aaaa', stok: 2, kategoriProduk: 'PCS', spesifikasiProduk: 'Keripik', tanggalMasuk: '20 Maret 2023', tanggalExpired: '20 April 2023' }
        ]
      };
    },
    mounted() {
      $(function () {
        $("#example1").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      });
    }
  }
  </script>
  
  <style>
  /* Add your custom styles here */
  </style>
  