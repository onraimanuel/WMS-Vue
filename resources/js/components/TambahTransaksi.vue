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
                            <!-- Tombol untuk menambah transaksi -->
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button
                                        @click="tambahTransaksi"
                                        class="btn btn-block bg-gradient-primary btn-sm"
                                    >
                                        Tambah Transaksi
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
            products: [],
            jumlahBarangKeluar: 0,
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
        async tambahTransaksi() {
            if (!this.selectedProduct) {
                alert("Silakan pilih produk terlebih dahulu");
                return;
            }

            if (this.jumlahBarangKeluar <= 0) {
                alert("Jumlah barang keluar harus lebih dari 0");
                return;
            }
            try {
                const response = await axios.post("/AddTransaksi", {
                    stock_id: this.selectedProduct,
                    jumlah_barang_keluar: this.jumlahBarangKeluar,
                });
                if (response.status === 200) {
                    alert("Transaksi berhasil ditambahkan");
                    this.$router.push("/TransaksiWarehouse");
                }
            } catch (error) {
                console.error("Error adding transaction:", error);
                alert("Gagal menambahkan transaksi. Silakan coba lagi.");
            }
        },
    },
};
</script>
