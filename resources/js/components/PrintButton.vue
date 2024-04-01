<template>
  <button @click="printTable" class="btn btn-primary"><i class="fas fa-print"></i> Stock Report Print</button>
</template>

<script>
export default {
  methods: {
    printTable() {
      // Dapatkan elemen tabel
      const table = document.getElementById('example1');

      // Buat salinan elemen tabel untuk dijadikan konten PDF
      const tableClone = table.cloneNode(true);

      // Sembunyikan tombol cetak dari salinan elemen tabel (jika ada)
      const printButtons = tableClone.querySelectorAll('.buttons-print');
      printButtons.forEach(button => {
        button.style.display = 'none';
      });

      // Buat objek window baru untuk pencetakan
      const win = window.open('', '_blank');

      // Tambahkan elemen tabel ke objek window
      win.document.body.appendChild(tableClone);

      // Cetak objek window
      win.print();
    }
  }
}
</script>

<style scoped>
.btn-primary {
  background-color: #000001;
  /* Ubah warna latar belakang sesuai keinginan */
  border-color: #000000;
  /* Sesuaikan warna border dengan warna latar belakang */
  border-radius: 20px;
  /* Atur ketajaman sudut tombol */
}
</style>