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
                                <label>Start Date : </label>
                            </div>
                            <div class="col-md-3">
                                <label>End Date : </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <flat-pickr
                                    v-model="datefilter"
                                    :config="datePickerConfig"
                                    :dateFormat="dateFormat"
                                ></flat-pickr>
                            </div>
                            <div class="col-md-3">
                                <flat-pickr
                                    v-model="endDateFilter"
                                    :config="datePickerConfig"
                                    :dateFormat="dateFormat"
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
                                    <td>{{ "Rp." + purchase.price }}</td>
                                    <td>
                                        {{
                                            "Rp." +
                                            purchase.price *
                                                purchase.jumlah_pembelian_produk
                                        }}
                                    </td>
                                    <td>
                                        {{ formatDate(purchase.created_at) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

export default {
    components: {
        flatPickr,
    },
    data() {
        return {
            product_purchases: [],
            datefilter: "",
            endDateFilter: "",
            datePickerConfig: {
                dateFormat: "d-m-Y",
            },
            currentPage: 1,
            perPage: 10,
        };
    },

    methods: {
        search() {
            if (!this.datefilter || !this.endDateFilter) {
                alert("Mohon untuk mengisi kedua tanggal.");
                return;
            }

            const startDate = moment(this.datefilter).format("YYYY-MM-DD");
            const endDate = moment(this.endDateFilter).format("YYYY-MM-DD");

            if (endDate < startDate) {
                alert("Tanggal akhir harus setelah tanggal awal.");
                return;
            }
            this.product_purchases = this.product_purchases.filter(
                (purchase) => {
                    const purchaseDate = moment(purchase.created_at).format(
                        "YYYY-MM-DD"
                    );
                    return purchaseDate >= startDate && purchaseDate <= endDate;
                }
            );
        },

        formatDate(date) {
            return moment(date).format("DD-MM-YYYY");
        },

        fetchData() {
            axios
                .get("http://127.0.0.1:8001/api/pembelian")
                .then((response) => {
                    this.product_purchases = response.data.product_purchases;
                })
                .catch((error) => {
                    console.error("Error fetching data:", error);
                });
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
        endIndex() {
            return Math.min(
                this.startIndex + this.perPage - 1,
                this.product_purchases.length
            );
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.product_purchases.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.product_purchases.length / this.perPage);
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
