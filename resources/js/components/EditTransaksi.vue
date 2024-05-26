<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="color: black; font-weight: bold">
                        Edit Transaksi
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form @submit.prevent="updateTransaction">
                                <div class="form-group row">
                                    <label for="productName" class="col-md-4 col-form-label text-md-right">
                                        Nama Produk
                                    </label>
                                    <div class="col-md-8">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="productName"
                                            v-model="transaction.product_name"
                                            required
                                            disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="namaMerchant" class="col-md-4 col-form-label text-md-right">
                                        Nama Toko
                                    </label>
                                    <div class="col-md-8">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="namaMerchant"
                                            v-model="transaction.nama_merchant"
                                            required
                                            disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jumlahBarangKeluar" class="col-md-4 col-form-label text-md-right">
                                        Jumlah Barang Keluar
                                    </label>
                                    <div class="col-md-8">
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="jumlahBarangKeluar"
                                            v-model="transaction.jumlah_barang_keluar"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggalKeluar" class="col-md-4 col-form-label text-md-right">
                                        Tanggal Transaksi
                                    </label>
                                    <div class="col-md-8">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="tanggalKeluar"
                                            v-model="transaction.tanggal_keluar"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-8 offset-md-4 d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary btn-sm" style="width: 45%;">
                                            Simpan Perubahan
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-sm" @click="cancelEdit" style="width: 45%;">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </form>
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
            transaction: {
                product_name: "",
                nama_merchant: "",
                jumlah_barang_keluar: "",
                tanggal_keluar: "",
            },
        };
    },
    mounted() {
        this.fetchTransactionData();
    },
    methods: {
        fetchTransactionData() {
            const transactionId = this.$route.params.id;
            axios
                .get(`/getTransaksi/${transactionId}`)
                .then((response) => {
                    this.transaction = response.data;
                    // Format tanggal_keluar ke format yang sesuai jika diperlukan
                    if (this.transaction.tanggal_keluar) {
                        this.transaction.tanggal_keluar = new Date(this.transaction.tanggal_keluar).toISOString().substr(0, 10);
                    }
                })
                .catch((error) => {
                    console.error("Error fetching data:", error);
                    Swal.fire("Error!", "Gagal mengambil data transaksi.", "error");
                });
        },
        updateTransaction() {
            const transactionId = this.$route.params.id;
            axios
                .put(`/updateTransaksi/${transactionId}`, this.transaction)
                .then((response) => {
                    Swal.fire("Sukses!", "Transaksi berhasil diperbarui.", "success");
                    this.$router.push("/TransaksiWarehouse");
                })
                .catch((error) => {
                    console.error("Error updating data:", error);
                    Swal.fire("Error!", "Gagal memperbarui transaksi.", "error");
                });
        },
        cancelEdit() {
            this.$router.push("/TransaksiWarehouse");
        },
    },
};
</script>

<style scoped>
.form-group {
    margin-bottom: 1rem;
}
</style>
