<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3
                        class="card-title"
                        style="color: red; font-weight: bold"
                    >
                        Tambah Produk
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <!-- Dropdown dan input "Nama Toko" -->
                            <div class="form-group row">
                                <label
                                    for="namaToko"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Nama Toko</label
                                >
                                <div class="col-md-8">
                                    <select
                                        v-model="selectedMerchant"
                                        class="form-control"
                                        id="namaToko"
                                        name="namaToko"
                                    >
                                        <option value="" disabled>
                                            Pilih Toko
                                        </option>
                                        <option
                                            v-for="merchant in merchants"
                                            :key="merchant.merchant_id"
                                            :value="merchant.merchant_id"
                                        >
                                            {{ merchant.nama_merchant }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!-- Label dan input "Kategori Produk" -->
                            <div class="form-group row">
                                <label
                                    for="kategoriProduk"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Kategori Produk</label
                                >
                                <div class="col-md-8">
                                    <select
                                        v-model="selectedCategory"
                                        class="form-control"
                                        id="kategoriProduk"
                                        name="kategoriProduk"
                                    >
                                        <option value="" disabled>
                                            Pilih Kategori
                                        </option>
                                        <option
                                            v-for="category in categories"
                                            :key="category.category_id"
                                            :value="category.category_id"
                                        >
                                            {{ category.nama_kategori }}
                                        </option>
                                    </select>
                                </div>
                            </div>
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
                                            :key="product.product_id"
                                            :value="product.product_id"
                                        >
                                            {{ product.product_name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!-- Label dan input "Spesifikasi Produk" -->
                            <div class="form-group row">
                                <label
                                    for="spesifikasiProduk"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Spesifikasi Produk</label
                                >
                                <div class="col-md-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="spesifikasiProduk"
                                        name="spesifikasiProduk"
                                        v-model="spesifikasiProduk"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    for="lokasi"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Lokasi</label
                                >
                                <div class="col-md-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="lokasi"
                                        name="lokasi"
                                        v-model="lokasi"
                                        required
                                    />
                                </div>
                            </div>
                            <!-- Label dan input "Jumlah" -->
                            <div class="form-group row">
                                <label
                                    for="jumlah"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Jumlah</label
                                >
                                <div class="col-md-8">
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="jumlah"
                                        name="jumlah"
                                        v-model="jumlah"
                                        required
                                    />
                                </div>
                            </div>
                            <!-- Label dan input "Tanggal Expired" -->
                            <div class="form-group row">
                                <label
                                    for="tanggalExpired"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Tanggal Expired</label
                                >
                                <div class="col-md-8">
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="tanggalExpired"
                                        name="tanggalExpired"
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
import axios from "axios";
export default {
    data() {
        return {
            namaProduk: "",
            selectedMerchant: null,
            selectedCategory: null,
            spesifikasiProduk: "",
            lokasi: "",
            jumlah: 0,
            tanggalExpired: "",
            merchants: [], // Menyimpan daftar tenant
            categories: [],
            products: [],
        };
    },

    mounted() {
        this.fetchMerchants();
        this.fetchCategories();
        this.fetchProducts();
    },

    methods: {
        async fetchMerchants() {
            try {
                const response = await fetch(
                    "http://127.0.0.1:8001/api/daftartenant"
                );

                if (!response.ok) {
                    throw new Error("Failed to fetch merchants");
                }

                const data = await response.json();

                this.merchants = data;
            } catch (error) {
                console.error("Error fetching merchants:", error);
            }
        },

        async fetchCategories() {
            try {
                const response = await fetch(
                    "http://127.0.0.1:8001/api/pilihkategori"
                );

                if (!response.ok) {
                    throw new Error("Failed to fetch categories");
                }

                const data = await response.json();

                this.categories = data;
            } catch (error) {
                console.error("Error fetching categories:", error);
            }
        },

        async fetchProducts() {
            try {
                const response = await fetch(
                    "http://127.0.0.1:8001/api/listdaftarproduk"
                );

                if (!response.ok) {
                    throw new Error("Failed to fetch products");
                }

                const data = await response.json();
                this.products = data;
            } catch (error) {
                console.error("Error fetching products:", error);
            }
        },
        async tambahProduk() {
            try {
                const response = await axios.post("/addstock", {
                    product_id: this.selectedProduct,
                    jumlah: this.jumlah,
                    tanggal_expired: this.tanggalExpired, // Menambahkan tanggal_expired ke objek permintaan
                    lokasi: this.lokasi,
                });

                if (response.status === 200) {
                    alert("Produk berhasil ditambahkan");
                    this.$router.push("/ProdukToko");
                }
            } catch (error) {
                console.error("Error adding product:", error);
                alert("Gagal menambahkan produk");
            }
        },

        clearInputs() {
            this.selectedMerchant = null;
            this.selectedCategory = null;
            this.selectedProduct = null;
            this.spesifikasiProduk = "";
            this.lokasi = "";
            this.jumlah = 0;
            this.tanggalExpired = "";
        },
    },
};
</script>
