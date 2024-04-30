<template>
        <section class="content">
          <div class="container-fluid">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Pembelian Produk</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Purchase Order</th>
                      <th>Nama Produk</th>
                      <th>Nama Toko</th>
                      <th>Jumlah</th>
                      <th>Status</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in pembelianProduk" :key="index">
                      <td>{{ index + 1 }}</td>
                      <td>{{ item.purchaseOrder }}</td>
                      <td>{{ item.namaProduk }}</td>
                      <td>{{ item.namaToko }}</td>
                      <td>{{ item.jumlah }}</td>
                      <td>
                        <select class="form-select" v-model="item.status">
                        <option value="Perlu Dikirim" style="background-color: #ffe6e6;">Perlu Dikirim</option>
                        <option value="Perlu Diambil" style="background-color: #ffffcc;">Perlu Diambil</option>
                        <option value="Selesai" style="background-color: #ccffcc;">Selesai</option>
                      </select>
                      </td>
                      <td>
                        <a href="#">Detail</a>
                      </td>
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
        pembelianProduk: [
          { purchaseOrder: '001', namaProduk: 'Kripik', namaToko: 'Bramstam', jumlah: 1, status: 'Perlu Dikirim' },
          { purchaseOrder: '002', namaProduk: 'Kripik', namaToko: 'Bramstam', jumlah: 1, status: 'Perlu Diambil' },
          { purchaseOrder: '003', namaProduk: 'Kripik', namaToko: 'Bramstam', jumlah: 1, status: 'Selesai' }
        ]
      };
    },
    mounted() {
      $(function () {
        $("#example1").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
      });
    }
  }
  </script>
  