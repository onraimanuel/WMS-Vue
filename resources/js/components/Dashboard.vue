<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>
                            <p>Barang Tersedia</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="/ProdukToko" class="small-box-footer"
                            >More info <i class="fas fa-arrow-circle-right"></i
                        ></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53</h3>

                            <p>Perlu Diambil</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a
                            href="http://127.0.0.1:8000/PembelianProduk"
                            class="small-box-footer"
                            >More info <i class="fas fa-arrow-circle-right"></i
                        ></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>

                            <p>Perlu Dikirim</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="/PembelianProduk" class="small-box-footer"
                            >More info <i class="fas fa-arrow-circle-right"></i
                        ></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>
                            <p>Barang Keluar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="/LaporanPemesanan" class="small-box-footer"
                            >More info <i class="fas fa-arrow-circle-right"></i
                        ></a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Produk</h3>
                    <div class="card-tools">
                        <div
                            class="input-group input-group-sm"
                            style="width: 150px"
                        >
                            <input
                                type="text"
                                class="form-control float-right"
                                placeholder="Cari"
                                v-model="searchTerm"
                                @input="searchProducts"
                            />
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table
                        id="example1"
                        class="table table-bordered table-striped"
                    >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Stok</th>
                                <th>Kategori Produk</th>
                                <th>Spesifikasi Produk</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Expired</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(product, index) in products"
                                :key="index"
                            >
                                <td>
                                    {{
                                        index + 1 + (currentPage - 1) * perPage
                                    }}
                                </td>
                                <td>{{ product.product_name }}</td>
                                <td>{{ product.stok }}</td>
                                <td>{{ product.kategori }}</td>
                                <td>{{ product.spesifikasi }}</td>
                                <td>{{ product.tanggal_masuk }}</td>
                                <td>{{ product.tanggal_expired }}</td>
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
                                        :class="{
                                            disabled: currentPage === 1,
                                        }"
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
                                    @click="redirectToTambahProduk"
                                >
                                    Tambah Produk
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <br />
        </div>
        <!-- /.container-fluid -->
    </section>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            products: [],
            currentPage: 1,
            perPage: 10,
            maxPageLinks: 5,
            searchTerm: "",
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
                this.products = response.data; // Ubah dari this.stok ke this.products
            } catch (error) {
                console.error("Error fetching products:", error);
            }
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
            this.$router.push("/TambahProduk");
        },
    },
    mounted() {
        this.fetchProducts();
    },
};
</script>
