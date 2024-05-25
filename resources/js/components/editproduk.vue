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
                                        readonly
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
                                        v-model="editedProduct.sisa_stok"
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
                                        readonly
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
                                        readonly
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
                                        readonly
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
                                        readonly
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
                                        readonly
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
import Swal from "sweetalert2";

export default {
    data() {
        return {
            editedProduct: {
                product_name: "",
                sisa_stok: 0,
                kategori: "",
                spesifikasi: "",
                hargamodal: 0,
                hargajual: 0,
                tanggal_masuk: "",
                tanggal_expired: "",
            },
        };
    },
    methods: {
        async fetchProductDetails() {
            const stockId = this.$route.params.id;
            try {
                const response = await axios.get(`/stok/${stockId}`);
                this.editedProduct = response.data;
                this.editedProduct.sisa_stok = response.data.sisa_stok;
            } catch (error) {
                console.error("Error fetching product details:", error);
            }
        },

        async editProduk() {
            const stockId = this.$route.params.id;
            try {
                await axios.put(`/stok/${stockId}`, {
                    sisa_stok: this.editedProduct.sisa_stok,
                    tanggal_expired: this.editedProduct.tanggal_expired,
                });

                Swal.fire({
                    title: "Berhasil!",
                    text: "Produk berhasil diupdate",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                this.$router.push("/ProdukToko"); 
                });
            } catch (error) {
                console.error("Error updating product:", error);
                
                Swal.fire({
                    title: "Gagal",
                    text: "Gagal mengupdate produk",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        }
    },
    created() {
        this.fetchProductDetails();
    },
};
</script>
