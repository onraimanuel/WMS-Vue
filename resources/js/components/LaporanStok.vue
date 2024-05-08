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
                                <th style="width: 5%">No</th>
                                <th style="width: 25%">Nama Toko</th>
                                <th style="width: 20%">Category</th>
                                <th style="width: 20%">Nama Produk</th>
                                <th style="width: 10%">Stok Masuk</th>
                                <th style="width: 10%">Stok Keluar</th>
                                <th style="width: 10%">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in displayedProducts"
                                :key="index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.namaToko }}</td>
                                <td>{{ item.category }}</td>
                                <td>{{ item.namaProduk }}</td>
                                <td class="text-center">
                                    {{ item.stokMasuk }}
                                </td>
                                <td class="text-center">
                                    {{ item.stokKeluar }}
                                </td>
                                <td class="text-center">{{ item.sisaStok }}</td>
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
import SearchInput from "@/components/SearchInput.vue";
import PrintButton from "./PrintButton.vue";

export default {
    components: {
        SearchInput,
        PrintButton,
    },
    data() {
        return {
            dataStok: [
                {
                    namaToko: "Loesi komp",
                    category: "makanan",
                    namaProduk: "Tela-tela",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Pt. Tbk",
                    category: "makanan",
                    namaProduk: "Sasagun",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Koperasi IT Del",
                    category: "makanan",
                    namaProduk: "Piza",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Loesi komp",
                    category: "makanan",
                    namaProduk: "Tela-tela",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Pt. Tbk",
                    category: "makanan",
                    namaProduk: "Sasagun",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Koperasi IT Del",
                    category: "makanan",
                    namaProduk: "Piza",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Loesi komp",
                    category: "makanan",
                    namaProduk: "Tela-tela",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Pt. Tbk",
                    category: "makanan",
                    namaProduk: "Sasagun",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Loesi komp",
                    category: "makanan",
                    namaProduk: "Tela-tela",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Pt. Tbk",
                    category: "makanan",
                    namaProduk: "Sasagun",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Koperasi IT Del",
                    category: "makanan",
                    namaProduk: "Piza",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Loesi komp",
                    category: "makanan",
                    namaProduk: "Tela-tela",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Pt. Tbk",
                    category: "makanan",
                    namaProduk: "Sasagun",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Koperasi IT Del",
                    category: "makanan",
                    namaProduk: "Piza",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Loesi komp",
                    category: "makanan",
                    namaProduk: "Tela-tela",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Pt. Tbk",
                    category: "makanan",
                    namaProduk: "Sasagun",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
                {
                    namaToko: "Koperasi IT Del",
                    category: "makanan",
                    namaProduk: "Piza",
                    stokMasuk: 10,
                    stokKeluar: 1,
                },
            ],
            filteredData: [],
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
        this.filteredData = this.dataStok;
    },
    methods: {
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
