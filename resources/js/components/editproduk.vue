<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3
                        class="card-title"
                        style="color: black; font-weight: bold"
                    >
                        Edit Produk
                    </h3>
                </div>
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
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="namaProduk"
                                        v-model="editedProduct.product_name"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="stok"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Stok</label
                                >
                                <div class="col-md-8">
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="stok"
                                        v-model="editedProduct.stok"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="kategoriProduk"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Kategori Produk</label
                                >
                                <div class="col-md-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="kategoriProduk"
                                        v-model="editedProduct.kategori"
                                        required
                                    />
                                </div>
                            </div>
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
                                        v-model="editedProduct.spesifikasi"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="hargaModal"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Harga Modal</label
                                >
                                <div class="col-md-8">
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="hargaModal"
                                        v-model="editedProduct.hargamodal"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="hargaJual"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Harga Jual</label
                                >
                                <div class="col-md-8">
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="hargaJual"
                                        v-model="editedProduct.hargajual"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="tanggalMasuk"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Tanggal Masuk</label
                                >
                                <div class="col-md-8">
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="tanggalMasuk"
                                        v-model="editedProduct.tanggal_masuk"
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
                                        v-model="editedProduct.tanggal_expired"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button
                                        @click="editProduk"
                                        class="btn btn-block bg-gradient-primary btn-sm"
                                    >
                                        Edit Produk
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
            editedProduct: {
                namaProduk: "",
                stok: 0,
                kategoriProduk: "",
                spesifikasiProduk: "",
                hargaModal: 0,
                hargaJual: 0,
                tanggalMasuk: "",
                tanggalExpired: "",
            },
        };
    },
    methods: {
        async fetchProductDetails() {
            const stockId = this.$route.params.id;
            try {
                const response = await axios.get(`/stok/${stockId}`);
                this.editedProduct = response.data;
            } catch (error) {
                console.error("Error fetching product details:", error);
            }
        },

        async editProduk() {
            // Implement your edit functionality here
            try {
                const stockId = this.$route.params.id;
                const response = await axios.put(
                    `/stok/${stockId}`,
                    this.editedProduct
                );
                console.log("Product updated successfully:", response.data);
                // Redirect or show success message
            } catch (error) {
                console.error("Error updating product:", error);
                // Show error message
            }
        },
    },
    mounted() {
        this.fetchProductDetails();
    },
};
</script>
