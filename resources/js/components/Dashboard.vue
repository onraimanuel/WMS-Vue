<template>
    <!-- Content Wrapper -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>
                            <p>Barang Tersedia</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer"
                            >More info <i class="fas fa-arrow-circle-right"></i
                        ></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53</h3>

                            <p>Perlu Diambil</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer"
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
                        <a href="#" class="small-box-footer"
                            >More info <i class="fas fa-arrow-circle-right"></i
                        ></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Barang Keluar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer"
                            >More info <i class="fas fa-arrow-circle-right"></i
                        ></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- Main row -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Produk</h3>
                </div>
                <!-- /.card-header -->
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
                                v-for="(product, index) in displayedProducts"
                                :key="index"
                            >
                                <td>
                                    {{
                                        index + 1 + (currentPage - 1) * perPage
                                    }}
                                </td>
                                <td>{{ product.product_name }}</td>
                                <td>{{ product.stok }}</td>
                                <td>{{ product.nama_kategori }}</td>
                                <td>
                                    {{ product.product_description }}
                                </td>
                                <!-- Tambahkan kolom untuk tanggal masuk dan tanggal expired -->
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
export default {
    data() {
        return {
            products: [],
            currentPage: 1,
            perPage: 10,
            maxPageLinks: 5,
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.products.length / this.perPage);
        },
        displayedProducts() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.products.slice(start, end);
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

            // Adjust startPage and endPage if there are not enough pages to display
            if (endPage - startPage + 1 < maxPageLinks) {
                startPage = Math.max(1, endPage - maxPageLinks + 1);
            }

            // Generate an array of page numbers to display
            return Array.from(
                { length: endPage - startPage + 1 },
                (_, i) => startPage + i
            );
        },
    },
    methods: {
        async fetchProducts() {
            try {
                const response = await fetch(
                    "http://kreatif.tobakab.go.id/api/produk"
                );
                let data = await response.json();
                // Urutkan data berdasarkan product_id secara descending
                data.products.sort((a, b) => b.product_id - a.product_id);
                this.products = data.products;
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
    },
    mounted() {
        this.fetchProducts();
    },
};
</script>

<style scoped>
/* Add your scoped CSS styles here */
</style>
