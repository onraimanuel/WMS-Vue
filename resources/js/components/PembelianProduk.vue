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
                                        v-for="(item, index) in filteredData"
                                        :key="index"
                                    >
                                        <td>{{ index + 1 }}</td>
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
                                                @click="showDetail(item)"
                                                >Detail</a
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-left">
                            <ul class="pagination pagination-sm m-0">
                                <li
                                    class="page-item"
                                    :class="{ disabled: currentPage === 1 }"
                                >
                                    <a
                                        href="#"
                                        class="page-link"
                                        @click.prevent="prevPage"
                                        >&laquo;</a
                                    >
                                </li>
                                <li
                                    class="page-item"
                                    v-for="page in pagesToShow"
                                    :key="page"
                                    :class="{ active: page === currentPage }"
                                >
                                    <a
                                        href="#"
                                        class="page-link"
                                        @click.prevent="changePage(page)"
                                        >{{ page }}</a
                                    >
                                </li>
                                <li
                                    class="page-item"
                                    :class="{
                                        disabled: currentPage === totalPages,
                                    }"
                                >
                                    <a
                                        href="#"
                                        class="page-link"
                                        @click.prevent="nextPage"
                                        >&raquo;</a
                                    >
                                </li>
                            </ul>
                        </div>
                        <div class="float-right">
                            <div class="dataTables_length" id="example1_length">
                                <label>
                                    Show
                                    <select
                                        v-model="perPage"
                                        class="custom-select custom-select-sm form-control form-control-sm"
                                        @change="updatePerPage"
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
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Modal -->
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
                                />
                            </div>
                            <div class="form-group">
                                <label for="namaCustomer">Nama Customer</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="namaCustomer"
                                    v-model="selectedItem.name"
                                />
                            </div>
                            <div class="form-group">
                                <label for="pembelian">Pesanan Barang</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="pemesananBarang"
                                    v-model="selectedItem.product_name"
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
                                    v-model="selectedItem.jumlah"
                                />
                            </div>
                            <div class="form-group">
                                <label for="namaToko">Nama Toko</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="namaToko"
                                    v-model="selectedItem.merchant_name"
                                />
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea
                                    class="form-control"
                                    id="alamat"
                                    v-model="selectedItem.alamat"
                                    rows="3"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select
                                    class="form-control"
                                    id="status"
                                    v-model="selectedItem.status"
                                >
                                    <option
                                        value="Perlu Dikirim"
                                        style="background-color: #ffe6e6"
                                    >
                                        Perlu Dikirim
                                    </option>
                                    <option
                                        value="Perlu Diambil"
                                        style="background-color: #ffffcc"
                                    >
                                        Perlu Diambil
                                    </option>
                                    <option
                                        value="Selesai"
                                        style="background-color: #ccffcc"
                                    >
                                        Selesai
                                    </option>
                                </select>
                            </div>
                            <div class="float-right">
                                <button
                                    type="button"
                                    class="btn btn-block bg-gradient-primary btn-sm"
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

export default {
    components: {
        SearchInput,
    },
    data() {
        return {
            product_purchases: [],
            filteredData: [],
            searchText: "",
            currentPage: 1,
            perPage: 10,
            entryOptions: [5, 10, 15, 20],
            selectedItem: null,
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.filteredData.length / this.perPage);
        },
        startIndex() {
            return (this.currentPage - 1) * this.perPage;
        },
        endIndex() {
            return this.startIndex + this.perPage;
        },
    },
    created() {
        axios
            .get("http://127.0.0.1:8001/api/pembelian")
            .then((response) => {
                this.product_purchases = response.data.product_purchases;
                this.filteredData = this.product_purchases;
            })
            .catch((error) => {
                console.error("Error fetching pembelian data:", error);
            });
    },

    methods: {
        filterData() {
            // Filter data based on searchText
            this.filteredData = this.product_purchases.filter(
                (item) =>
                    item.purchase_id
                        .toString()
                        .toLowerCase()
                        .includes(this.searchText.toLowerCase()) ||
                    item.kode_pembelian
                        .toLowerCase()
                        .includes(this.searchText.toLowerCase()) ||
                    item.status_pembelian
                        .toLowerCase()
                        .includes(this.searchText.toLowerCase()) ||
                    item.name
                        .toLowerCase()
                        .includes(this.searchText.toLowerCase()) ||
                    item.username
                        .toLowerCase()
                        .includes(this.searchText.toLowerCase())
            );
        },

        showDetail(item) {
            axios
                .get(
                    `http://127.0.0.1:8001/api/pembelian?purchase_id=${item.purchase_id}`
                )
                .then((response) => {
                    const selectedPurchase = response.data.purchases[0];
                    const selectedProduct =
                        response.data.product_purchases.find(
                            (product) =>
                                product.purchase_id === item.purchase_id
                        );
                    this.selectedItem = {
                        kode_pembelian: selectedPurchase.kode_pembelian,
                        name: selectedPurchase.name,
                        product_name: selectedProduct.product_name,
                        jumlah: selectedProduct.jumlah_pembelian_produk,
                        merchant_name: selectedProduct.nama_merchant,
                        status: selectedPurchase.status_pembelian,
                        alamat: selectedPurchase.alamat_pengiriman,
                    };
                    // Tampilkan modal
                    $("#detailModal").modal("show");
                })
                .catch((error) => {
                    console.error("Error fetching item detail:", error);
                });
        },

        changePage(page) {
            this.currentPage = page;
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
        updatePerPage() {
            // You can implement logic here if needed
            this.filterData();
        },
    },
};
</script>
