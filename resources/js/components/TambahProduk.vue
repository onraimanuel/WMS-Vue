<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
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
                            <div class="form-group row">
                                <label
                                    for="spesifikasi"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Spesifikasi Produk</label
                                >
                                <div class="col-md-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="spesifikasi"
                                        name="spesifikasi"
                                        v-model="spesifikasi"
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
                            <div class="form-group row">
                                <label
                                    for="hargamodal"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Harga Modal</label
                                >

                                <div class="col-md-8">
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="hargamodal"
                                        name="hargamodal"
                                        v-model="hargamodal"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="hargajual"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Harga Jual</label
                                >

                                <div class="col-md-8">
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="hargajual"
                                        name="hargajual"
                                        v-model="hargajual"
                                        required
                                    />
                                </div>
                            </div>
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
import { inject } from "vue";

export default {
    data() {
        return {
            namaProduk: "",
            selectedMerchant: "",
            selectedCategory: null,
            spesifikasi: "",
            lokasi: "",
            jumlah: 0,
            hargamodal: 0,
            hargajual: 0,
            tanggalExpired: "",
            merchants: [],
            categories: [],
            products: [],
        };
    },

    setup() {
        const apiUrl = inject("apiUrl");
        return { apiUrl };
    },

    mounted() {
        this.fetchMerchants();
        this.fetchCategories();
        this.fetchProducts();
    },

    methods: {
        async fetchMerchants() {
            try {
                const response = await axios.get(`${this.apiUrl}/daftartenant`);
                this.merchants = response.data;
            } catch (error) {
                console.error("Error fetching merchants:", error);
            }
        },

        async fetchCategories() {
            try {
                const response = await axios.get(
                    `${this.apiUrl}/pilihkategori`
                );
                this.categories = response.data;
            } catch (error) {
                console.error("Error fetching categories:", error);
            }
        },

        async fetchProducts() {
            try {
                const response = await axios.get(
                    `${this.apiUrl}/listdaftarproduk`
                );
                this.products = response.data;
            } catch (error) {
                console.error("Error fetching products:", error);
            }
        },

        async tambahProduk() {
            try {
                const response = await axios.post(`/addstock`, {
                    product_id: this.selectedProduct,
                    merchant_id: this.selectedMerchant,
                    jumlah: this.jumlah,
                    spesifikasi: this.spesifikasi,
                    hargamodal: this.hargamodal,
                    hargajual: this.hargajual,
                    tanggal_expired: this.tanggalExpired,
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
    },
};
</script>
