<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Pemesanan Barang</h3>
                </div>
                <div class="card-body">
                    <div class="container float-left">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Tanggal Awal : </label>
                            </div>
                            <div class="col-md-3">
                                <label>Tanggal Akhir : </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <flat-pickr
                                    v-model="datefilter"
                                    :config="datePickerConfig"
                                ></flat-pickr>
                            </div>
                            <div class="col-md-3">
                                <flat-pickr
                                    v-model="endDateFilter"
                                    :config="datePickerConfig"
                                ></flat-pickr>
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button
                                    type="button"
                                    class="btn btn-info btn-sm btn-block"
                                    @click="search"
                                >
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table
                            id="example2"
                            class="table table-bordered table-hover"
                            v-if="purchases.length > 0"
                        >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Purchase Order</th>
                                    <th>Nama Produk</th>
                                    <th>Nama Toko</th>
                                    <th>Jumlah</th>
                                    <th>Harga per Unit</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal Pemesanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(purchase, index) in paginatedData"
                                    :key="index"
                                >
                                    <td>{{ startIndex + index }}</td>
                                    <td>{{ purchase.kode_pembelian }}</td>
                                    <td>{{ purchase.product_name }}</td>
                                    <td>{{ purchase.nama_merchant }}</td>
                                    <td>
                                        {{ purchase.jumlah_pembelian_produk }}
                                    </td>
                                    <td>
                                        {{ formatToRupiah(purchase.price) }}
                                    </td>
                                    <td>
                                        {{
                                            formatToRupiah(
                                                purchase.price *
                                                    purchase.jumlah_pembelian_produk
                                            )
                                        }}
                                    </td>
                                    <td>
                                        {{ formatDate(purchase.created_at) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-else>
                            <table
                                id="example2"
                                class="table table-bordered table-hover"
                            >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Purchase Order</th>
                                        <th>Nama Produk</th>
                                        <th>Nama Toko</th>
                                        <th>Jumlah</th>
                                        <th>Harga per Unit</th>
                                        <th>Total Harga</th>
                                        <th>Tanggal Pemesanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <p>{{ noDataMessage }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br />
                        <div class="row">
                            <ul class="pagination float-right">
                                <li
                                    class="page-item"
                                    :class="{ disabled: currentPage === 1 }"
                                >
                                    <button class="page-link" @click="prevPage">
                                        &laquo;
                                    </button>
                                </li>
                                <li
                                    class="page-item"
                                    v-for="page in pagesToShow"
                                    :key="page"
                                    :class="{
                                        active: page === currentPage,
                                    }"
                                >
                                    <button
                                        class="page-link"
                                        @click="currentPage = page"
                                    >
                                        {{ page }}
                                    </button>
                                </li>
                                <li
                                    class="page-item"
                                    :class="{
                                        disabled: currentPage === totalPages,
                                    }"
                                >
                                    <button class="page-link" @click="nextPage">
                                        &raquo;
                                    </button>
                                </li>
                                <li
                                    class="page-item"
                                    :class="{
                                        disabled: currentPage === totalPages,
                                    }"
                                ></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
import moment from "moment";
import flatPickr from "vue-flatpickr-component";
import { inject } from "vue";

export default {
    components: {
        flatPickr,
    },
    data() {
        return {
            originalPurchases: [],
            purchases: [],
            datefilter: "",
            endDateFilter: "",
            datePickerConfig: {
                dateFormat: "d-m-Y",
            },
            currentPage: 1,
            perPage: 10,
            noDataMessage: "",
        };
    },
    setup() {
        const apiUrl = inject("apiUrl");
        return { apiUrl };
    },
    methods: {
        formatDate(date) {
            return moment(date, "YYYY-MM-DD").format("DD-MM-YYYY");
        },

        search() {
            if (!this.datefilter || !this.endDateFilter) {
                this.noDataMessage = "Mohon pilih rentang tanggal.";
                this.purchases = [];
                return;
            }

            const startDate = moment(this.datefilter, "DD-MM-YYYY", true);
            const endDate = moment(this.endDateFilter, "DD-MM-YYYY", true);

            if (!startDate.isValid() || !endDate.isValid()) {
                this.noDataMessage = "Format tanggal tidak valid.";
                this.purchases = [];
                return;
            }

            if (startDate.isAfter(endDate)) {
                this.noDataMessage =
                    "Tanggal akhir harus setelah tanggal awal.";
                this.purchases = [];
                return;
            }

            this.purchases = this.originalPurchases.filter((purchase) => {
                const purchaseDate = moment(purchase.created_at);
                return purchaseDate.isBetween(startDate, endDate, null, "[]");
            });

            if (this.purchases.length === 0) {
                this.noDataMessage =
                    "Tidak ada data pada rentang tanggal yang dipilih.";
            } else {
                this.noDataMessage = "";
            }
        },

        async fetchData() {
            try {
                const url = `${this.apiUrl}/pembelian`;
                const response = await axios.get(url);
                this.originalPurchases = response.data.purchases;
                this.purchases = [...this.originalPurchases];
            } catch (error) {
                console.error("Error fetching data:", error);
            }
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
        formatToRupiah(amount) {
            return amount.toLocaleString("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            });
        },
    },
    mounted() {
        this.fetchData();
        $(function () {
            $("#example2").DataTable({
                paging: false,
                lengthChange: false,
                searching: false,
                ordering: true,
                info: false,
                autoWidth: false,
                responsive: true,
            });
        });
    },

    computed: {
        startIndex() {
            return this.currentPage > 1
                ? (this.currentPage - 1) * this.perPage + 1
                : 1;
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.purchases.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.purchases.length / this.perPage);
        },
        pagesToShow() {
            const maxVisiblePages = 5;
            const pages = [];
            let startPage = 1;
            let endPage = Math.min(maxVisiblePages, this.totalPages);

            if (this.currentPage > Math.floor(maxVisiblePages / 2)) {
                startPage = this.currentPage - Math.floor(maxVisiblePages / 2);
                endPage = this.currentPage + Math.floor(maxVisiblePages / 2);
                if (endPage > this.totalPages) {
                    endPage = this.totalPages;
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                pages.push(i);
            }
            return pages;
        },
    },
};
</script>
