<template>
        <section class="content">
          <div class="container-fluid">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Laporan Pemesanan Barang</h3>
              </div>
              <div class="card-body">
                <div class="container">
                  <div class="form-group row">
                      <div class="col-md-3 btn-block mt-2">
                      <label>Start Date:</label>
                      <flat-pickr v-model="datefilter" :config="datePickerConfig"></flat-pickr>
                    </div>
                     <div class="col-md-3 btn-block mt-2">
                    <label>End Date:</label>
                    <flat-pickr v-model="endDateFilter" :config="datePickerConfig"></flat-pickr>
                  </div>
                  <div class="col-md-2 align-self-end"> 
                      <button type="button" class="btn btn-info btn-sm btn-block mt-1" @click="search">Cari</button>
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

        </section>
  </template>
  
  <script>
  import flatPickr from 'vue-flatpickr-component';
export default {
  components:{
    flatPickr,
  },
  data() {
    return {
      datePickerConfig: {
        dateFormat: 'd/m/Y',
      },
      datefilter: '',
      endDateFilter: '', // Tambahkan endDateFilter di data
      laporanPemesanan: [
        { purchaseOrder: '01', namaProduk: 'Sasagun Andaliman', namaToko: 'Bramstam', jumlah: 1, hargaPerUnit: '10.000', totalHarga: '10.000', tanggalPemesanan: '26/11/2023' },
        { purchaseOrder: '02', namaProduk: 'Sasagun Andaliman', namaToko: 'Bramstam', jumlah: 1, hargaPerUnit: '10.000', totalHarga: '10.000', tanggalPemesanan: '26/11/2023' },
        { purchaseOrder: '03', namaProduk: 'Sasagun Andaliman', namaToko: 'Bramstam', jumlah: 1, hargaPerUnit: '10.000', totalHarga: '10.000', tanggalPemesanan: '26/11/2023' }
      ]
    };
  },
  methods: {
    search() {
      // Parsing tanggal dari string input ke objek Date
      const startDate = new Date(this.datefilter);
      const endDate = new Date(this.endDateFilter); // Menggunakan endDateFilter yang telah ditambahkan

      // Filter laporanPemesanan berdasarkan rentang tanggal
      const filteredLaporanPemesanan = this.laporanPemesanan.filter(item => {
        // Parsing tanggal pemesanan dari string ke objek Date
        const tanggalPemesanan = new Date(item.tanggalPemesanan);
        // Membandingkan apakah tanggal pemesanan berada di antara rentang tanggal yang dipilih
        return tanggalPemesanan >= startDate && tanggalPemesanan <= endDate;
      });

      // Mengupdate data laporanPemesanan dengan data yang telah difilter
      this.laporanPemesanan = filteredLaporanPemesanan;
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
  