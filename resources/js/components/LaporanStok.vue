<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Stok Barang</h3>
                </div>
                <div class="card-body table-responsive">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="dataTables_length" id="example1_length">
                                <label
                                    >Show
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
                                    entries
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <PrintButton class="btn btn-primary btn-block" />
                            <SearchInput
                                v-model="searchText"
                                @search-input="handleSearchInput"
                                placeholder="Search"
                                class="form-control"
                            />
                        </div>
                    </div>
                    <table
                        id="example1"
                        class="table table-bordered table-striped"
                        style="width: 95%"
                    >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Toko</th>
                                <th>Category</th>
                                <th>Nama Produk</th>
                                <th>Stok Masuk</th>
                                <th>Stok Keluar</th>
                                <th>Sisa Stok</th>
                                <th>Harga Modal</th>
                                <th>Harga Jual</th>
                                <th>Total Keuntungan</th>
                                <th>Tanggal Masuk</th>
                                <th>Transaksi Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in displayedProducts"
                                :key="index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.merchant_name }}</td>
                                <td>{{ item.kategori }}</td>
                                <td>{{ item.product_name }}</td>
                                <td class="text-center">
                                    {{ item.stok }}
                                </td>
                                <td class="text-center">
                                    {{ item.total_barang_keluar }}
                                </td>
                                <td class="text-center">
                                    {{ item.stok_tersisa }}
                                </td>
                                <td class="text-center">
                                    {{ formatToRupiah(item.hargamodal) }}
                                </td>
                                <td class="text-center">
                                    {{ formatToRupiah(item.hargajual) }}
                                </td>

                                <td class="text-center">
                                    {{
                                        formatToRupiah(
                                            (item.hargajual - item.hargamodal) *
                                                item.total_barang_keluar
                                        )
                                    }}
                                </td>
                                <td>
                                    {{ formatDate(item.tanggal_masuk) }}
                                </td>
                                <td class="text-center">
                                    {{ formatDate(item.transaksi_terakhir) }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="10" class="text-right">
                                    <strong
                                        >Total Keuntungan Keseluruhan:</strong
                                    >
                                </td>
                                <td colspan="2" class="text-center">
                                    <strong>{{
                                        formatToRupiah(
                                            totalKeuntunganKeseluruhan
                                        )
                                    }}</strong>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
import moment from "moment"; // tambahkan import moment

import SearchInput from "@/components/SearchInput.vue";
import PrintButton from "./PrintButton.vue";

export default {
    components: {
        SearchInput,
        PrintButton,
    },
    data() {
        return {
            dataStok: [],
            filteredData: [],
            searchText: "",
            currentPage: 1,
            perPage: 10,
            maxPageLinks: 5,
            entryOptions: [5, 10, 15, 20],
            totalKeuntunganKeseluruhan: 0, // tambahkan properti totalKeuntunganKeseluruhan
        };
    },

    computed: {
        totalPages() {
            return Math.ceil(this.filteredData.length / this.perPage);
        },
        displayedProducts() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredData.slice(start, end).map((item) => ({
                ...item,
                sisaStok: item.stokMasuk - item.stokKeluar,
            }));
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
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            axios
                .get("/LaporandataStok")
                .then((response) => {
                    this.dataStok = response.data;
                    this.filteredData = this.dataStok;
                    this.hitungTotalKeuntunganKeseluruhan(); // panggil fungsi hitungTotalKeuntunganKeseluruhan
                })
                .catch((error) => {
                    console.error("Error fetching data:", error);
                });
        },
        handleSearchInput(searchValue) {
            this.filteredData = this.dataStok.filter(
                (item) =>
                    item.namaToko
                        .toLowerCase()
                        .includes(searchValue.toLowerCase()) ||
                    item.category
                        .toLowerCase()
                        .includes(searchValue.toLowerCase()) ||
                    item.namaProduk
                        .toLowerCase()
                        .includes(searchValue.toLowerCase()) ||
                    item.stokMasuk
                        .toString()
                        .toLowerCase()
                        .includes(searchValue.toLowerCase()) ||
                    item.stokKeluar
                        .toString()
                        .toLowerCase()
                        .includes(searchValue.toLowerCase())
            );
            this.hitungTotalKeuntunganKeseluruhan(); // panggil fungsi hitungTotalKeuntunganKeseluruhan
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
        formatDate(date) {
            return moment(date).format("DD-MM-YYYY");
        },
        formatToRupiah(amount) {
            return amount.toLocaleString("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            });
        },
        hitungTotalKeuntunganKeseluruhan() {
            this.totalKeuntunganKeseluruhan = this.filteredData.reduce(
                (total, item) => {
                    return (
                        total +
                        (item.hargajual - item.hargamodal) *
                            item.total_barang_keluar
                    );
                },
                0
            );
        },
    },
};
</script>

<style>
.col-sm-2 > * {
    margin-bottom: 7px;
    position: relative;
    left: 110px;
}

.table table-bordered table-striped > * {
    margin-bottom: 8px;
    width: relative;
}
</style>
