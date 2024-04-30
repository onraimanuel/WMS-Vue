<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Pembelian Produk</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <!-- Show Entries -->
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
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <!-- Include SearchInput component here -->
                            <SearchInput
                                v-model="searchText"
                                @search-input="filterData"
                                placeholder="Search"
                                class="form-control"
                            />
                        </div>
                    </div>
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
                                <td>{{ item.purchaseOrder }}</td>
                                <td>{{ item.namaProduk }}</td>
                                <td>{{ item.namaToko }}</td>
                                <td>{{ item.jumlah }}</td>
                                <td>
                                    <select
                                        class="form-select"
                                        v-model="item.status"
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
                                </td>
                                <td>
                                    <a href="#" @click="showDetail(item)"
                                        >Detail</a
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Detail Modal -->
        <div
            class="modal fade"
            id="detailModal"
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
                                    v-model="selectedItem.purchaseOrder"
                                    disabled
                                />
                            </div>
                            <div class="form-group">
                                <label for="namaCustomer">Nama Customer</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="namaCustomer"
                                    v-model="selectedItem.namaCustomer"
                                    disabled
                                />
                            </div>
                            <div class="form-group">
                                <label for="pembelian">Pesanan Barang</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="pemesananBarang"
                                    v-model="selectedItem.namaProduk"
                                    disabled
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
                                    disabled
                                />
                            </div>
                            <div class="form-group">
                                <label for="namaToko">Nama Toko</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="namaToko"
                                    v-model="selectedItem.namaToko"
                                    disabled
                                />
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea
                                    class="form-control"
                                    id="alamat"
                                    v-model="selectedItem.alamat"
                                    rows="3"
                                    disabled
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select
                                    class="form-control"
                                    id="status"
                                    v-model="selectedItem.status"
                                    disabled
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import SearchInput from "@/components/SearchInput.vue";

export default {
    components: {
        SearchInput,
    },
    data() {
        return {
            pembelianProduk: [
                {
                    purchaseOrder: "001",
                    namaProduk: "Kripik",
                    namaToko: "Bramstam",
                    jumlah: 1,
                    status: "Perlu Dikirim",
                    namaCustomer: "Loeis",
                    alamat: "Jl. Raya No. 123",
                },
                {
                    purchaseOrder: "002",
                    namaProduk: "Kripik",
                    namaToko: "Bramstam",
                    jumlah: 1,
                    status: "Perlu Diambil",
                    namaCustomer: "Loeis",
                    alamat: "Jl. Raya No. 123",
                },
                {
                    purchaseOrder: "003",
                    namaProduk: "Kripik",
                    namaToko: "Bramstam",
                    jumlah: 1,
                    status: "Selesai",
                    namaCustomer: "Loeis",
                    alamat: "Jl. Raya No. 123",
                },
            ],
            filteredData: [],
            searchText: "",
            currentPage: 1,
            perPage: 10,
            maxPageLinks: 5,
            entryOptions: [5, 10, 15, 20],
            selectedItem: null,
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.filteredData.length / this.perPage);
        },
    },
    created() {
        this.filteredData = this.pembelianProduk;
    },
    methods: {
        filterData() {
            this.filteredData = this.pembelianProduk.filter(
                (item) =>
                    item.purchaseOrder
                        .toLowerCase()
                        .includes(this.searchText.toLowerCase()) ||
                    item.namaProduk
                        .toLowerCase()
                        .includes(this.searchText.toLowerCase()) ||
                    item.namaToko
                        .toLowerCase()
                        .includes(this.searchText.toLowerCase()) ||
                    item.status
                        .toLowerCase()
                        .includes(this.searchText.toLowerCase())
            );
        },
        showDetail(item) {
            this.selectedItem = item;
            $("#detailModal").modal("show");
        },
    },
};
</script>