<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Pembelian Produk</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div
                                        class="dataTables_length"
                                        id="example1_length"
                                    >
                                        <label>
                                            Show
                                            <select
                                                v-model="perPage"
                                                class="custom-select custom-select-sm form-control form-control-sm"
                                            >
                                                <option
                                                    v-for="option in entryOptions"
                                                    :key="option"
                                                    :value="option"
                                                >
                                                    {{ option }}
                                                </option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <SearchInput
                                        v-model="searchText"
                                        @search-input="filterData"
                                        placeholder="Search"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <br />
                            <table
                                id="example1"
                                class="table table-bordered table-striped"
                            >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Purchase Order</th>
                                        <th>Nama Produk</th>
                                        <th>Nama Toko</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(item, index) in paginatedData"
                                        :key="index"
                                    >
                                        <td>
                                            {{
                                                (currentPage - 1) * perPage +
                                                index +
                                                1
                                            }}
                                        </td>
                                        <td>{{ item.kode_pembelian }}</td>
                                        <td>{{ item.product_name }}</td>
                                        <td>{{ item.nama_merchant }}</td>
                                        <td>
                                            {{ item.jumlah_pembelian_produk }}
                                        </td>
                                        <td>{{ item.status_pembelian }}</td>
                                        <td>
                                            <a
                                                href="#"
                                                @click.prevent="
                                                    showDetail(item)
                                                "
                                                >Detail</a
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br />
                            <ul class="pagination">
                                <li
                                    class="page-item"
                                    :class="{ disabled: currentPage === 1 }"
                                >
                                    <a
                                        class="page-link"
                                        href="#"
                                        aria-label="Previous"
                                        @click.prevent="prevPage"
                                    >
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li
                                    class="page-item"
                                    v-for="pageNumber in displayedPages"
                                    :key="pageNumber"
                                    :class="{
                                        active: pageNumber === currentPage,
                                    }"
                                >
                                    <a
                                        class="page-link"
                                        href="#"
                                        @click.prevent="changePage(pageNumber)"
                                        >{{ pageNumber }}</a
                                    >
                                </li>
                                <li
                                    class="page-item"
                                    :class="{
                                        disabled: currentPage === totalPages,
                                    }"
                                >
                                    <a
                                        class="page-link"
                                        href="#"
                                        aria-label="Next"
                                        @click.prevent="nextPage"
                                    >
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            id="detailModal"
            class="modal fade"
            tabindex="-1"
            role="dialog"
            aria-labelledby="detailpembelianbarang"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">
                            Detail Pembelian Barang
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form v-if="selectedItem">
                            <div class="form-group">
                                <label for="purchaseOrder"
                                    >Purchase Order</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="purchaseOrder"
                                    v-model="selectedItem.kode_pembelian"
                                    readonly
                                />
                            </div>
                            <div class="form-group">
                                <label for="namaCustomer">Nama Customer</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="namaCustomer"
                                    v-model="selectedItem.name"
                                    readonly
                                />
                            </div>
                            <div class="form-group">
                                <label for="pembelian">Pesanan Barang</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="pemesananBarang"
                                    v-model="selectedItem.product_name"
                                    readonly
                                />
                            </div>
                            <div class="form-group">
                                <label for="jumlahPesanan"
                                    >Jumlah Pesanan</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="jumlahPesanan"
                                    v-model="
                                        selectedItem.jumlah_pembelian_produk
                                    "
                                    readonly
                                />
                            </div>
                            <div class="form-group">
                                <label for="namaToko">Nama Toko</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="namaToko"
                                    v-model="selectedItem.nama_merchant"
                                    readonly
                                />
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea
                                    class="form-control"
                                    id="alamat"
                                    v-model="selectedItem.user_street_address"
                                    rows="3"
                                    readonly
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <textarea
                                    class="form-control"
                                    id="status_pembelian"
                                    v-model="selectedItem.status_pembelian"
                                    rows="3"
                                    readonly
                                ></textarea>
                            </div>
                            <div class="float-right">
                                <button
                                    type="button"
                                    class="btn btn-block bg-gradient-primary btn-sm"
                                    @click="saveChanges"
                                >
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import SearchInput from "@/components/SearchInput.vue";
import axios from "axios";
import { inject } from "vue";

export default {
    components: {
        SearchInput,
    },
    data() {
        return {
            purchases: [],
            filteredData: [],
            searchText: "",
            currentPage: 1,
            perPage: 10,
            entryOptions: [5, 10, 15, 20],
            selectedItem: null,
        };
    },
    setup() {
        const apiUrl = inject("apiUrl");
        return { apiUrl };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.filteredData.length / this.perPage);
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredData.slice(start, end);
        },
        displayedPages() {
            const maxDisplayedPages = 5;
            const startPage = Math.max(
                1,
                this.currentPage - Math.floor(maxDisplayedPages / 2)
            );
            const endPage = Math.min(
                this.totalPages,
                startPage + maxDisplayedPages - 1
            );
            const pages = [];
            for (let i = startPage; i <= endPage; i++) {
                pages.push(i);
            }
            return pages;
        },
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            axios
                .get(`${this.apiUrl}/pembelian`)
                .then((response) => {
                    const purchases = response.data.purchases.map((item) => ({
                        ...item,
                        status_pembelian: this.getStatusPembelian(
                            item.status_pembelian,
                            item.proof_of_payment_image
                        ),
                    }));
                    this.purchases = purchases;
                    this.filteredData = purchases;
                })
                .catch((error) => {
                    console.error("Error fetching pembelian data:", error);
                });
        },
        getStatusPembelian(status_pembelian, proof_of_payment_image) {
            let status = "";
            if (
                status_pembelian === "status1" ||
                status_pembelian === "status1_ambil"
            ) {
                status = proof_of_payment_image
                    ? "Bukti Pembayaran Telah Dikirim. SILAHKAN KONFIRMASI."
                    : "Belum Dapat Dikonfirmasi. TUNGGU BUKTI PEMBAYARAN.";
            } else if (
                status_pembelian === "status2" ||
                status_pembelian === "status2_ambil"
            ) {
                status = "Pesanan Sedang Diproses. TUNGGU PESANAN DIPROSES.";
            } else if (status_pembelian === "status3_ambil") {
                status = "MENUNGGU PELANGGAN MENGAMBIL PESANAN.";
            } else if (status_pembelian === "status3") {
                status =
                    "Pesanan Sedang Dalam Perjalanan. TUNGGU PESANAN DITERIMA.";
            } else if (status_pembelian === "status4_ambil_a") {
                status =
                    "Pesanan telah diberikan. TUNGGU PELANGGAN MENGKONFIRMASI PESANAN YANG TELAH DIAMBIL.";
            } else if (
                status_pembelian === "status4" ||
                status_pembelian === "status4_ambil_b"
            ) {
                status = "Transaksi Sukses. SILAHKAN KIRIM BAYARAN.";
            } else if (
                status_pembelian === "status5" ||
                status_pembelian === "status5_ambil"
            ) {
                status = "PENJUALAN DAN PEMBELIAN BERHASIL.";
            }
            return status;
        },
        filterData() {
            this.filteredData = this.purchases.filter((item) => {
                return (
                    item.kode_pembelian
                        .toLowerCase()
                        .includes(this.searchText.toLowerCase()) ||
                    item.product_name
                        .toLowerCase()
                        .includes(this.searchText.toLowerCase()) ||
                    item.nama_merchant
                        .toLowerCase()
                        .includes(this.searchText.toLowerCase())
                );
            });
        },
        showDetail(item) {
            this.selectedItem = item;
            $("#detailModal").modal("show");
        },
        changePage(pageNumber) {
            this.currentPage = pageNumber;
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        saveChanges() {
            $("#detailModal").modal("hide");
        },
    },
};
</script>
