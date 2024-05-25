<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Produk Baru</h3>
                </div>
                <div class="card-body table-responsive">
                    <table
                        v-if="newProducts.length > 0"
                        id="new-products-table"
                        class="table table-bordered table-striped"
                    >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Nama Tenant</th>
                                <th>Jumlah Masuk</th>
                                <th>Kategori Produk</th>
                                <th>Spesifikasi Produk</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Expired</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(product, index) in newProducts"
                                :key="index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ product.product_name }}</td>
                                <td>{{ product.merchant_name }}</td>
                                <td>{{ product.sisa_stok }}</td>
                                <td>{{ product.kategori }}</td>
                                <td>{{ product.spesifikasi }}</td>
                                <td>{{ formatDate(product.tanggal_masuk) }}</td>
                                <td>
                                    {{ formatDate(product.tanggal_expired) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-else class="card-body table-responsive">
                        <p>Produk Baru Kosong</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Produk Akan Kedaluwarsa</h3>
                </div>
                <div class="card-body table-responsive">
                    <table
                        v-if="expiringProducts.length > 0"
                        id="expiring-products-table"
                        class="table table-bordered table-striped"
                    >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Nama Tenant</th>
                                <th>Jumlah Barang Tersedia</th>
                                <th>Kategori Produk</th>
                                <th>Spesifikasi Produk</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Expired</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(product, index) in expiringProducts"
                                :key="index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ product.product_name }}</td>
                                <td>{{ product.merchant_name }}</td>
                                <td>{{ product.sisa_stok }}</td>
                                <td>{{ product.kategori }}</td>
                                <td>{{ product.spesifikasi }}</td>
                                <td>{{ formatDate(product.tanggal_masuk) }}</td>
                                <td>
                                    {{ formatDate(product.tanggal_expired) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-else class="card-body table-responsive">
                        <p>Produk Akan Kedaluwarsa Kosong</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
import moment from "moment";

export default {
    data() {
        return {
            products: [],
            newProducts: [],
            expiringProducts: [],
            transaksi: [],
            currentPage: 1,
            perPage: 10,
            maxPageLinks: 5,
            searchTerm: "",
            totalStockAvailable: 0,
            totalItemsSold: 0,
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.filteredProducts.length / this.perPage);
        },
        displayedProducts() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredProducts.slice(start, end);
        },
        filteredProducts() {
            return this.products.filter((product) => {
                return product.product_name
                    .toLowerCase()
                    .includes(this.searchTerm.toLowerCase());
            });
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
    methods: {
        async fetchProducts() {
            try {
                const response = await axios.get("/stok");
                console.log(response.data);
                this.products = response.data;

                this.totalStockAvailable = this.calculateTotalStockAvailable();

                await this.fetchTransactions();

                this.totalItemsSold = this.calculateTotalItemsSold();

                this.fetchNewProducts();
                this.fetchExpiringProducts();
            } catch (error) {
                console.error("Error fetching products:", error);
            }
        },
        async fetchTransactions() {
            try {
                const response = await axios.get("/LaporandataStok");
                console.log(response.data);
                this.transaksi = response.data;
            } catch (error) {
                console.error("Error fetching transactions:", error);
            }
        },
        fetchNewProducts() {
            this.newProducts = this.products.filter((product) => {
                const today = moment();
                const productDate = moment(product.tanggal_masuk);
                return today.diff(productDate, "days") <= 1; //Data untuk barang yang baru masuk
            });
        },
        fetchExpiringProducts() {
            this.expiringProducts = this.products.filter((product) => {
                const today = moment();
                const expirationDate = moment(product.tanggal_expired);
                return expirationDate.diff(today, "days") <= 30; //Data untuk Barang yang ingin Exp
            });
        },
        calculateTotalStockAvailable() {
            return this.products.reduce((total, product) => {
                return total + product.sisa_stok;
            }, 0);
        },
        calculateTotalItemsSold() {
            return this.transaksi.reduce((total, transaksi) => {
                return total + transaksi.total_barang_keluar;
            }, 0);
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
        searchProducts() {
            this.currentPage = 1;
        },
        redirectToTambahProduk() {
            window.location.href = "/TambahProduk";
        },
        formatDate(date) {
            return moment(date).format("DD-MM-YYYY");
        },
    },
    mounted() {
        this.fetchProducts();
    },
};
</script>

<style scoped>
ul {
    list-style-type: none;
    padding: 0;
}

li {
    margin: 0.5em 0;
}

h2 {
    margin-top: 1.5em;
}
</style>
