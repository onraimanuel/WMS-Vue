<template>
    <div class="wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Produk</h3>
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
                                    <th style="width: 10%">Kategori Produk</th>
                                    <th style="width: 20%">
                                        Spesifikasi Produk
                                    </th>
                                    <th>Harga Modal</th>
                                    <th>Harga Jual</th>
                                    <th>Berat Produk</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Expired</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(product, index) in products"
                                    :key="index"
                                >
                                    <td class="text-center">
                                        {{
                                            index +
                                            1 +
                                            (currentPage - 1) * perPage
                                        }}
                                    </td>
                                    <td>
                                        {{ product.product_name }}
                                    </td>
                                    <td class="text-center">
                                        {{ product.sisa_stok }}
                                    </td>
                                    <td class="text-center">
                                        {{ product.kategori }}
                                    </td>
                                    <td class="text-center">
                                        {{ product.spesifikasi }}
                                    </td>
                                    <td class="text-center">
                                        {{ product.berat }}
                                    </td>
                                    <td class="text-center">
                                        {{ formatToRupiah(product.hargamodal) }}
                                    </td>
                                    <td class="text-center">
                                        {{ formatToRupiah(product.hargajual) }}
                                    </td>
                                    <td class="text-center">
                                        {{ formatDate(product.tanggal_masuk) }}
                                    </td>
                                    <td class="text-center">
                                        {{
                                            formatDate(product.tanggal_expired)
                                        }}
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
                                                    @click="
                                                        editProduct(
                                                            product.stock_id
                                                        )
                                                    "
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
                                                    @click="
                                                        deleteProduct(
                                                            product.stock_id
                                                        )
                                                    "
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
                                    <ul
                                        class="pagination justify-content-start"
                                    >
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
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import axios from "axios";
import Swal from "sweetalert2";
import moment from "moment";

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
                this.products = response.data;
            } catch (error) {
                console.error("Error fetching products:", error);
            }
        },
        editProduct(stockId) {
            this.$router.push({ name: "EditProduk", params: { id: stockId } });
        },
        async deleteProduct(stockId) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Anda tidak akan bisa mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await axios.delete(`/stok/${stockId}`);

                        if (response.status === 200) {
                            this.products = this.products.filter(
                                (product) => product.stock_id !== stockId
                            );
                            Swal.fire(
                                "Terhapus!",
                                response.data.message ||
                                    "Produk berhasil dihapus.",
                                "success"
                            );
                        } else {
                            Swal.fire(
                                "Gagal!",
                                "Gagal menghapus produk.",
                                "error"
                            );
                        }
                    } catch (error) {
                        console.error("Error deleting product:", error);
                        Swal.fire(
                            "Gagal!",
                            `Gagal menghapus produk: ${
                                error.response
                                    ? `${error.response.status} - ${error.response.statusText}`
                                    : error.message
                            }`,
                            "error"
                        );
                    }
                }
            });
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
        formatToRupiah(amount) {
            return amount.toLocaleString("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            });
        },
    },
    mounted() {
        this.fetchProducts();
    },
};
</script>
<style scoped></style>
