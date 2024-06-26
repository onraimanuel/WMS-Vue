<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaksi pada Warehouse</h3>
                </div>
                <div class="card-body table-responsive">
                    <table
                        id="example1"
                        class="table table-bordered table-striped"
                        style="width: 95%"
                    >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">Nama Produk</th>
                                <th class="text-center">Nama Toko</th>
                                <th class="text-center">Jumlah Barang Keluar</th>
                                <th class="text-center">Tanggal Transaksi</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(transaction, index) in paginatedData"
                                :key="transaction.transaksi_id"
                            >
                                <td>
                                    {{
                                        (currentPage - 1) * perPage + index + 1
                                    }}
                                </td>
                                <td>{{ transaction.product_name }}</td>
                                <td>{{ transaction.nama_merchant }}</td>
                                <td class="text-center">
                                    {{ transaction.jumlah_barang_keluar }}
                                </td>
                                <td class="text-center">
                                    {{ formatDate(transaction.tanggal_keluar) }}
                                </td>
                                <td class="text-center">
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <button
                                                class="btn btn-success btn-sm rounded-0"
                                                type="button"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Edit"
                                                @click="redirectToEditTransaksi(transaction.transaksi_id)"
                                            >
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </li>
                                        <li class="list-inline-item">
                                            <button
                                                class="btn btn-danger btn-sm rounded-0"
                                                type="button"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Delete"
                                                @click="deleteTransaction(transaction.transaksi_id)"
                                            >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br />
                    <div class="row">
                        <div class="col-md-6">
                            <nav>
                                <ul class="pagination justify-content-start">
                                    <li
                                        class="page-item"
                                        :class="{ disabled: currentPage === 1 }"
                                    >
                                        <button
                                            class="page-link"
                                            @click="prevPage"
                                        >
                                            &laquo;
                                        </button>
                                    </li>
                                    <li
                                        v-for="n in pagesToShow"
                                        :key="n"
                                        :class="{
                                            'page-item': true,
                                            active: currentPage === n,
                                        }"
                                    >
                                        <button
                                            class="page-link"
                                            @click="gotoPage(n)"
                                        >
                                            {{ n }}
                                        </button>
                                    </li>
                                    <li
                                        class="page-item"
                                        :class="{
                                            disabled:
                                                currentPage === totalPages,
                                        }"
                                    >
                                        <button
                                            class="page-link"
                                            @click="nextPage"
                                        >
                                            &raquo;
                                        </button>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <button
                                    type="button"
                                    class="btn btn-block bg-gradient-primary btn-sm"
                                    @click="redirectToTambahTransaksi"
                                >
                                    Tambah Transaksi
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-block bg-gradient-danger btn-sm mt-2"
                                    @click="redirectToReportBarang"
                                >
                                    Report Barang Rusak/Hilang
                                </button>

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
import moment from "moment";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            dataStok: [],
            filteredData: [],
            paginatedData: [],
            searchText: "",
            currentPage: 1,
            perPage: 10,
            maxPageLinks: 5,
            entryOptions: [5, 10, 15, 20],
        };
    },

    computed: {
        totalPages() {
            return Math.ceil(this.filteredData.length / this.perPage);
        },

        pagesToShow() {
            const pageCount = this.totalPages;
            const currentPage = this.currentPage;
            const maxPageLinks = this.maxPageLinks;

            let startPage = Math.max(
                1,
                currentPage - Math.floor(maxPageLinks / 2)
            );
            let endPage = Math.min(pageCount, startPage + maxPageLinks - 1);

            if (endPage - startPage + 1 < maxPageLinks) {
                startPage = Math.max(1, endPage - maxPageLinks + 1);
            }
            return Array.from(
                { length: endPage - startPage + 1 },
                (_, i) => startPage + i
            );
        },
    },
    watch: {
        currentPage() {
            this.paginateData();
        },
        perPage() {
            this.paginateData();
        },
        filteredData() {
            this.paginateData();
        },
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            axios
                .get("/dataTransaksi")
                .then((response) => {
                    this.dataStok = response.data;
                    this.filteredData = this.dataStok;
                    this.paginateData();
                })
                .catch((error) => {
                    console.error("Error fetching data:", error);
                });
        },

        deleteTransaction(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Transaksi ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/deleteTransaksi/${id}`)
                        .then((response) => {
                            Swal.fire(
                                'Deleted!',
                                response.data.message,
                                'success'
                            );
                            this.fetchData();
                        })
                        .catch((error) => {
                            console.error("Error deleting data:", error);
                            Swal.fire(
                                'Error!',
                                'Gagal menghapus transaksi.',
                                'error'
                            );
                        });
                }
            });
        },

        redirectToTambahTransaksi() {
            window.location.href = "/TambahTransaksi";
        },
        redirectToReportBarang() {
            this.$router.push({ path: '/ReportBarang' });
        },
        redirectToEditTransaksi(id) {
            this.$router.push({ name: "EditTransaksi", params: { id } });
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        gotoPage(page) {
            this.currentPage = page;
        },
        paginateData() {
            const startIndex = (this.currentPage - 1) * this.perPage;
            const endIndex = startIndex + this.perPage;
            this.paginatedData = this.filteredData.slice(startIndex, endIndex);
        },
        formatDate(date) {
            return moment(date).format("DD-MM-YYYY");
        },
    },
};
</script>
<style scoped>
.page-item.disabled .page-link {
    pointer-events: none;
    opacity: 0.6;
}

.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.table table-bordered table-striped > * {
    margin-bottom: 8px;
    width: relative;
}
</style>
