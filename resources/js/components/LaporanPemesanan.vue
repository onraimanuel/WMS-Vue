<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Pemesanan Barang</h3>
                </div>
                <div class="card-body">
                    <div class="container">
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
                                ></flat-pickr>
                            </div>
                            <div class="col-md-3">
                                <flat-pickr
                                    v-model="endDateFilter"
                                    :config="datePickerConfig"
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
                                    v-for="(item, index) in laporanPemesanan"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.purchaseOrder }}</td>
                                    <td>{{ item.namaProduk }}</td>
                                    <td>{{ item.namaToko }}</td>
                                    <td>{{ item.jumlah }}</td>
                                    <td>{{ item.hargaPerUnit }}</td>
                                    <td>{{ item.totalHarga }}</td>
                                    <td>{{ item.tanggalPemesanan }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div
                                class="dataTables_info"
                                id="example2_info"
                                role="status"
                                aria-live="polite"
                            >
                                Showing 1 to 10 of
                                {{ laporanPemesanan.length }} entries
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
import flatPickr from "vue-flatpickr-component";

export default {
    components: {
        flatPickr,
    },
    data() {
        return {
            laporanPemesananAwal: [],
            laporanPemesanan: [],
            datefilter: "",
            endDateFilter: "",
        };
    },
    methods: {
        search() {
            if (this.datefilter && !this.endDateFilter) {
            alert("Mohon untuk mengisi End Date");
            return; 
        }
            
            const startDate = moment(this.datefilter, "DD-MM-YYYY").toDate();
            const endDate = moment(this.endDateFilter, "DD-MM-YYYY").toDate();

            axios

            .get(`http://127.0.0.1:8001/api/pembelian?start_date=${startDate}&end_date=${endDate}`)
                .then((response) => {
                    this.laporanPemesanan = response.data;
                    if (this.laporanPemesanan.length === 0) {
                        alert("Tidak ada data laporan pemesanan barang yang sesuai dengan rentang tanggal yang dipilih.");
                    }
                })
                .catch((error) => {
                    console.error("Error fetching data:", error);
                });

            const filteredLaporanPemesanan = this.laporanPemesananAwal.filter(
                (item) => {
                    const tanggalPemesanan = moment(
                        item.tanggalPemesanan,
                        "DD/MM/YYYY"
                    ).toDate();
                    return (
                        tanggalPemesanan >= startDate &&
                        tanggalPemesanan <= endDate
                    );
                }
            );

            if (filteredLaporanPemesanan.length === 0) {
            alert("Tidak ada data laporan pemesanan barang yang sesuai dengan rentang tanggal yang dipilih.");
            return;
        }

            this.laporanPemesanan = filteredLaporanPemesanan;
        },
    },
    mounted() {
        axios
        .get("http://127.0.0.1:8001/api/pembelian")
            .then((response) => {
                this.laporanPemesananAwal = response.data;
                this.laporanPemesanan = response.data;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });

        this.laporanPemesanan = this.laporanPemesananAwal;

        $(function () {
            $("#example2").DataTable({
                paging: true,
                lengthChange: false,
                searching: false,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
            });
        });
    },
};
</script>
