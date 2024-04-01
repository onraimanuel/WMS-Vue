<template>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Laporan Pemesanan Barang</h3>
        </div>
        <div class="card-body">
          <div class="container">
            <div class="form-group">
              <label>Tanggal:</label>
              <div class="row">
                <div class="col-md-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" v-model="datefilter">
                    <div class="col-md-4">
                      <button type="button" class="btn btn-info" @click="search">Cari</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Purchase Order</th>
                  <th>Nama Produk</th>
                  <th>Nama Toko</th>
                  <th>Jumlah</th>
                  <th>Harga per Unit</th>
                  <th>Total Harga</th>
                  <th>Tanggal Pemesanan</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in laporanPemesanan" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ item.purchaseOrder }}</td>
                  <td>{{ item.namaProduk }}</td>
                  <td>{{ item.namaToko }}</td>
                  <td>{{ item.jumlah }}</td>
                  <td>{{ item.hargaPerUnit }}</td>
                  <td>{{ item.totalHarga }}</td>
                  <td>{{ item.tanggalPemesanan }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      datefilter: '',
      laporanPemesanan: [
        { purchaseOrder: '01', namaProduk: 'Sasagun Andaliman', namaToko: 'Bramstam', jumlah: 1, hargaPerUnit: '10.000', totalHarga: '10.000', tanggalPemesanan: '26/11/2023' },
        { purchaseOrder: '02', namaProduk: 'Sasagun Andaliman', namaToko: 'Bramstam', jumlah: 1, hargaPerUnit: '10.000', totalHarga: '10.000', tanggalPemesanan: '26/11/2023' },
        { purchaseOrder: '03', namaProduk: 'Sasagun Andaliman', namaToko: 'Bramstam', jumlah: 1, hargaPerUnit: '10.000', totalHarga: '10.000', tanggalPemesanan: '26/11/2023' }
      ]
    };
  },
  methods: {
    search() {
      // Implement your search logic here
    }
  },
  mounted() {
    $(function () {
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

<style>
/* Add your custom styles here */
</style>