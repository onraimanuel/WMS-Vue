import { createApp, provide } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import moment from "moment";
import axios from "axios";
import Login from "./components/Login.vue";
import Dashboard from "./components/Dashboard.vue";
import ProdukToko from "./components/ProdukToko.vue";
import PembelianProduk from "./components/PembelianProduk.vue";
import LaporanPemesanan from "./components/LaporanPemesanan.vue";
import LaporanStok from "./components/LaporanStok.vue";
import TambahProduk from "./components/TambahProduk.vue";
import TransaksiWarehouse from "./components/TransaksiWarehouse.vue";
import TambahTransaksi from "./components/TambahTransaksi.vue";
import EditProduk from "./components/EditProduk.vue";
import EditTransaksi from "./components/EditTransaksi.vue";
import Notifikasi from "./components/Notifikasi.vue";
import ReportBarang from "./components/ReportBarang.vue";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";

const API_URL = "https://kreatif.tobakab.go.id/api";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: "/login", component: Login },
        { path: "/", component: Dashboard },
        { path: "/ProdukToko", component: ProdukToko },
        { path: "/PembelianProduk", component: PembelianProduk },
        { path: "/LaporanPemesanan", component: LaporanPemesanan },
        { path: "/LaporanStok", component: LaporanStok },
        { path: "/TambahProduk", component: TambahProduk },
        { path: "/ReportBarang", component: ReportBarang },
        { path: "/EditProduk/:id", name: "EditProduk", component: EditProduk },
        {
            path: "/EditTransaksi/:id",
            name: "EditTransaksi",
            component: EditTransaksi,
        },
        { path: "/TransaksiWarehouse", component: TransaksiWarehouse },
        { path: "/TambahTransaksi", component: TambahTransaksi },
        { path: "/Notifikasi", component: Notifikasi },
    ],
});

const app = createApp({
    setup() {
        provide("apiUrl", API_URL);
    },
});

app.use(router);
app.component("flat-pickr", flatPickr);
app.mount("#app");
