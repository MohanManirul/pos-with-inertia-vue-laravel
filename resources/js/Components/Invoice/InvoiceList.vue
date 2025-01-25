<script setup>
import { ref } from "vue";
import InvoiceDetails from "./InvoiceDetails.vue";
import { Link, usePage, useForm, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";

const toaster = createToaster({ });



const show = ref(false);
const customer=ref();
const page = usePage();

const searchValue = ref();
const searchField = ref(["customer.name"]);
const headers = [
    { text: "No", value: "id" },
    { text: "Name", value: "customer.name" },
    { text: "Moblie", value: "customer.mobile" },
    { text: "Total", value: "total" },
    { text: "Vat", value: "vat" },
    { text: "Discount", value: "discount" },
    { text: "Payable", value: "payable" },
    { text: "Action", value: "action" },
];

const items = ref(page.props.list);

const deleteInvoice = (id) => {
    if (confirm("Are you sure you want to delete this Invoice?")) {
        router.get(`/delete-invoice?id=${id}`);
    }

};

if(page.props.flash.status===true){
    toaster.success(page.props.flash.message);
}

const showDetails = (id) => {
    show.value =! show.value
    customer.value=items.value.find((item) => item.id === id);
}



</script>

<template>

    <div class="p-4 bg-[#f8f8f8]">
        <InvoiceDetails v-model:show="show" :customer="customer"/>
        <input
            v-model="searchValue"
            type="text"
            class="mb-2 px-2 py-1 w-[300px] border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
            placeholder="Search...."
        />
        <EasyDataTable
            buttons-pagination
            alternating
            :headers="headers"
            :items="items"
            :search-value="searchValue"
            :search-field="searchField"
            :rows-per-page="5"
        >
            <template #item-action="{ id }">

                <button
                    @click="showDetails(id)">
                    <span class="material-icons">visibility</span>
                </button>
                <button @click="deleteInvoice(id)">
                    <span class="material-icons">delete</span>
                </button>

            </template>

        </EasyDataTable>

    </div>
</template>

<style scoped></style>
