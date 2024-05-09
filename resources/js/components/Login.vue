<template>
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <img
                    src="/Asset/gambar/iconlogin.png"
                    alt=""
                    style="max-width: 100%; height: auto; padding-bottom: 10%"
                />
                <center>
                    <p class="login-box-msg;"><b>Masuk</b></p>
                </center>
                <form @submit.prevent="login">
                    <div class="input-group mb-3" style="padding-bottom: 10px">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Username atau Email"
                            v-model="username"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input
                            type="password"
                            class="form-control"
                            placeholder="Password"
                            v-model="password"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="row"
                        style="padding-bottom: 30px; padding-top: 30px"
                    >
                        <div class="col-12">
                            <button
                                type="submit"
                                class="btn btn-danger btn-block"
                            >
                                Masuk
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            username: "",
            password: "",
        };
    },
    methods: {
        login() {
            if (!this.username || !this.password) {
                alert("Mohon isi username dan password.");
                return;
            }
            axios
                .post("/postLogin", {
                    username: this.username,
                    password: this.password,
                })
                .then((response) => {
                    if (response.data.redirect) {
                        window.location.href = response.data.redirect;
                    } else {
                        alert("Anda tidak bisa masuk.");
                    }
                })
                .catch((error) => {
                    console.error(error);
                    alert("Username dan Password salah.");
                });
        },
    },
};
</script>

<style scoped></style>
