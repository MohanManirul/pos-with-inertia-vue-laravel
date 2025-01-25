<script setup>
import { ref } from "vue";
import { Link,usePage,useForm, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });

const page = usePage();
const searchValue = ref();
const searchField = ref(["name", "price"]);
const headers = [
    { text: "No", value: "id" },
    { text: "Name", value: "name" },
    { text: "Mobile", value: "mobile"},
    { text: "Email", value: "email"},
    { text: "Action", value: "action" },
];

const items = ref(page.props.customers);

const deleteCustomer = (id) => {
    if (confirm("Are you sure you want to delete this customer?")) {
        router.get(`/delete-customer?id=${id}`);
        toaster.success("Customer deleted successfully");
    }
};
</script>

<template>
    <div class="p-4 bg-[#f8f8f8]">
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
                <Link
                    :href="`/customer-save-page?id=${id}`"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                >
                    Edit
                </Link>
                <button
                    @click="deleteCustomer(name)"
                    class="bg-red-500 ml-1 text-white font-bold py-2 px-4 rounded"
                >
                    Delete
                </button>
            </template>

        </EasyDataTable>
        <div class="mt-4">
            <Link :href="`/customer-save-page?id=${0}`" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">Create</Link>
        </div>
    </div>
</template>

<style scoped></style>
