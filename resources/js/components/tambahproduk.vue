<template>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="color: red; font-weight: bold">
            Tambah Produk
          </h3>
        </div>
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <!-- Label dan input "Nama Produk" -->
              <div class="form-group row">
                <label for="namaProduk" class="col-md-4 col-form-label text-md-right">Nama Produk</label>
                <div class="col-md-8">
                  <input
                    type="text"
                    class="form-control"
                    id="namaProduk"
                    v-model="namaProduk"
                    required
                  />
                </div>
              </div>
              <!-- Label dan input "Nama Toko" -->
              <div class="form-group row">
                <label for="namaToko" class="col-md-4 col-form-label text-md-right">Nama Toko</label>
                <div class="col-md-8">
                  <input
                    type="text"
                    class="form-control"
                    id="namaToko"
                    v-model="namaToko"
                    required
                  />
                </div>
              </div>
              <!-- Label dan input "Kategori Produk" -->
              <div class="form-group row">
                <label for="kategoriProduk" class="col-md-4 col-form-label text-md-right">Kategori Produk</label>
                <div class="col-md-8">
                  <input
                    type="text"
                    class="form-control"
                    id="kategoriProduk"
                    v-model="kategoriProduk"
                    required
                  />
                </div>
              </div>
              <!-- Label dan input "Spesifikasi Produk" -->
              <div class="form-group row">
                <label for="spesifikasiProduk" class="col-md-4 col-form-label text-md-right">Spesifikasi Produk</label>
                <div class="col-md-8">
                  <input
                    type="text"
                    class="form-control"
                    id="spesifikasiProduk"
                    v-model="spesifikasiProduk"
                    required
                  />
                </div>
              </div>
              <!-- Label dan input "Jumlah" -->
              <div class="form-group row">
                <label for="jumlah" class="col-md-4 col-form-label text-md-right">Jumlah</label>
                <div class="col-md-8">
                  <input
                    type="number"
                    class="form-control"
                    id="jumlah"
                    v-model="jumlah"
                    required
                  />
                </div>
              </div>
              <!-- Label dan input "Tanggal Expired" -->
              <div class="form-group row">
                <label for="tanggalExpired" class="col-md-4 col-form-label text-md-right">Tanggal Expired</label>
                <div class="col-md-8">
                  <input
                    type="date"
                    class="form-control"
                    id="tanggalExpired"
                    v-model="tanggalExpired"
                    required
                  />
                </div>
              </div>
              <!-- Tombol "Tambah Produk" -->
              <div class="form-group row">
                <div class="col-md-8 offset-md-4">
                  <button
                    @click="tambahProduk"
                    class="btn btn-block bg-gradient-primary btn-sm"
                  >
                    Tambah Produk
                  </button>
                </div>
              </div>
            </div>
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
      namaProduk: "",
      namaToko: "",
      kategoriProduk: "",
      spesifikasiProduk: "",
      jumlah: 0,
      tanggalExpired: ""
    };
  },

  methods: {
    async tambahProduk() {
      // Lakukan validasi data
      if (
        !this.namaProduk ||
        !this.namaToko ||
        !this.kategoriProduk ||
        !this.spesifikasiProduk ||
        this.jumlah <= 0 ||
        !this.tanggalExpired
      ) {
        alert("Mohon lengkapi semua field");
        return;
      }

      const backendURL = "https://github.com/NestyTampubolon/RumahKreatifBackend.git";

      // Kirim data produk ke server atau store Vuex
      try {
        const response = await fetch(backendURL, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            namaProduk: this.namaProduk,
            namaToko: this.namaToko,
            kategoriProduk: this.kategoriProduk,
            spesifikasiProduk: this.spesifikasiProduk,
            jumlah: this.jumlah,
            tanggalExpired: this.tanggalExpired
          })
        });

        if (!response.ok) {
          throw new Error("Failed to add product");
        }

        this.clearInputs();

        alert("Produk berhasil ditambahkan");
      } catch (error) {
        console.error("Error adding product:", error);
        alert("Gagal menambahkan produk");
      }
    },
    clearInputs() {
      // Bersihkan nilai input setelah produk berhasil ditambahkan
      this.namaProduk = "";
      this.namaToko = "";
      this.kategoriProduk = "";
      this.spesifikasiProduk = "";
      this.jumlah = 0;
      this.tanggalExpired = "";
    }
  }
};
</script>
  
  