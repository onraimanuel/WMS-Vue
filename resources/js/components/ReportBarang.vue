<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label
                                    for="namaProduk"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Nama Produk</label
                                >
                                <div class="col-md-8">
                                    <select
                                        v-model="selectedProduct"
                                        class="form-control"
                                        id="namaProduk"
                                        name="namaProduk"
                                    >
                                        <option value="" disabled>
                                            Pilih Produk
                                        </option>
                                        <option
                                            v-for="product in products"
                                            :key="product.stock_id"
                                            :value="product.stock_id"
                                        >
                                            {{ product.product_name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="namaPenanggungJawab"
                                    class="col-md-4 col-form-label text-md-right"
                                >
                                    Nama Penanggung Jawab
                                </label>
                                <div class="col-md-8">
                                    <input
                                        type="text"
                                        v-model="namaPenanggungJawab"
                                        class="form-control"
                                        id="namaPenanggungJawab"
                                        name="namaPenanggungJawab"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="kondisiBarang"
                                    class="col-md-4 col-form-label text-md-right"
                                >
                                    Kondisi Barang
                                </label>
                                <div class="col-md-8">
                                    <select
                                        v-model="kondisiBarang"
                                        class="form-control"
                                        id="kondisiBarang"
                                        name="kondisiBarang"
                                    >
                                        <option value="" disabled>
                                            Pilih Kondisi
                                        </option>
                                        <option value="rusak">Rusak</option>
                                        <option value="hilang">Hilang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="jumlahBarangKeluar"
                                    class="col-md-4 col-form-label text-md-right"
                                >
                                    Jumlah Barang Keluar
                                </label>
                                <div class="col-md-8">
                                    <input
                                        type="number"
                                        v-model="jumlahBarangKeluar"
                                        class="form-control"
                                        id="jumlahBarangKeluar"
                                        name="jumlahBarangKeluar"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="tanggalKeluar"
                                    class="col-md-4 col-form-label text-md-right"
                                >
                                    Tanggal Keluar
                                </label>
                                <div class="col-md-8">
                                    <input
                                        type="date"
                                        v-model="tanggalKeluar"
                                        class="form-control"
                                        id="tanggalKeluar"
                                        name="tanggalKeluar"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button
                                        @click="reportBarang"
                                        class="btn btn-block bg-gradient-primary btn-sm"
                                    >
                                        Report Barang
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
import axios from "axios";
export default {
    data() {
        return {
            selectedProduct: null,
            namaPenanggungJawab: "",
            kondisiBarang: "",
            jumlahBarangKeluar: 0,
            tanggalKeluar: null,
            products: [],
        };
    },

    mounted() {
        this.fetchProducts();
    },

    methods: {
        async fetchProducts() {
            try {
                const response = await fetch("/stok");

                if (!response.ok) {
                    throw new Error("Failed to fetch products");
                }

                const data = await response.json();
                this.products = data;
            } catch (error) {
                console.error("Error fetching products:", error);
            }
        },
        async reportBarang() {
            if (!this.selectedProduct) {
                alert("Silakan pilih produk terlebih dahulu");
                return;
            }

            if (this.jumlahBarangKeluar <= 0) {
                alert("Jumlah barang keluar harus lebih dari 0");
                return;
            }

            if (!this.kondisiBarang) {
                alert("Silakan pilih kondisi barang");
                return;
            }

            try {
                const response = await axios.post("/ReportBarang", {
                    stock_id: this.selectedProduct,
                    nama_penanggung_jawab: this.namaPenanggungJawab,
                    kondisi_barang: this.kondisiBarang,
                    jumlah_barang_keluar: this.jumlahBarangKeluar,
                    tanggal_keluar: this.tanggalKeluar,
                });

                if (response.status === 200) {
                    alert("Report berhasil ditambahkan");
                    this.$router.push("/TransaksiWarehouse");
                }
            } catch (error) {
                console.error("Error reporting barang:", error);
                alert("Gagal membuat report. Silakan coba lagi.");
            }
        },
    },
};
</script>
