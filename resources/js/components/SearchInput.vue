<template>
    <input
        type="text"
        v-model="searchText"
        @input="handleInput"
        :placeholder="placeholder"
        class="form-control mb-3"
    />
</template>

<script>
export default {
    props: {
        value: {
            type: String,
            default: "",
        },
        placeholder: {
            type: String,
            default: "Search",
        },
        dataToSearch: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            searchText: this.value,
        };
    },
    watch: {
        value(newVal) {
            this.searchText = newVal;
        },
    },
    methods: {
        handleInput() {
            this.$emit("input", this.searchText);
            this.$emit("search-input", this.searchText);
        },
    },
};
</script>

<style scoped>
.form-control mb-3 {
    border-color: #000000;
    /* Sesuaikan warna border dengan warna latar belakang */
}
</style>
