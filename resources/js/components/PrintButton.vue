<template>
    <button @click="printTable" class="btn btn-primary">
        <i class="fas fa-print"></i> Stock Report Print
    </button>
</template>

<script>
export default {
    methods: {
        printTable() {
            const table = document.getElementById("example1");
            const tableClone = table.cloneNode(true);
            const printButtons = tableClone.querySelectorAll(".buttons-print");
            printButtons.forEach((button) => {
                button.style.display = "none";
            });
            const win = window.open("", "_blank");
            win.document.body.appendChild(tableClone);
            win.print();
        },
    },
};
</script>

<style scoped>
.btn-primary {
    background-color: #000001;
    border-color: #000000;
    border-radius: 20px;
}
</style>
