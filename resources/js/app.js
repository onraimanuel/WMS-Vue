import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "./components/Dashboard.vue";
import ProdukToko from "./components/ProdukToko.vue";
import PembelianProduk from "./components/PembelianProduk.vue";
import LaporanPemesanan from "./components/LaporanPemesanan.vue";
import LaporanStok from "./components/LaporanStok.vue";
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';



// Membuat router
const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/", component: Dashboard },
    { path: "/ProdukToko", component: ProdukToko },
    { path: "/PembelianProduk", component: PembelianProduk },
    { path: "/LaporanPemesanan", component: LaporanPemesanan },
    { path: "/LaporanStok", component: LaporanStok },
  ],
});

// Membuat aplikasi
const app = createApp({});
app.use(router);
app.component('flat-pickr', flatPickr);

// Mount aplikasi ke elemen dengan id "app"
app.mount("#app");

