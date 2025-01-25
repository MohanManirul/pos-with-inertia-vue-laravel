<script setup>
import { ref } from "vue";
import { Link,usePage,useForm, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });

const page = usePage();

const searchValue = ref();
const searchField = ref(["name"]);
const headers = [
    { text: "No", value: "id" },
    { text: "Image", value: "img_url" },
    { text: "Name", value: "name", sortable: true },
    { text: "Price", value: "price", sortable: true },
    { text: "Qty", value: "unit" },
    { text: "Action", value: "action" },
];

const items = ref(page.props.products);



const deleteProduct = (id) => {
    if (confirm("Are you sure you want to delete this product?")) {
        router.get(`/delete-product?id=${id}`);
    }
};

if(page.props.flash.status===true){
  toaster.success(page.props.flash.message);
}
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
           <template #item-img_url="{ img_url }">
                <img :src="img_url" class="w-10 h-10" />

           </template>
            <template #item-action="{ id }">
                <Link
                    :href="`/product-save-page?id=${id}`"

                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                >
                    Edit
                </Link>
                <button
                    @click="deleteProduct(id)"
                    class="bg-red-500 ml-1 text-white font-bold py-2 px-4 rounded"
                >
                    Delete
                </button>
            </template>
        </EasyDataTable>
        <div class="mt-4">
        <Link
            :href="`/product-save-page?id=${0}`"
            class="w-full px-4 py-2 text-white bg-orange-600 rounded-lg hover:bg-orange-700"
        >
            Add Product
        </Link>
    </div>
    </div>

</template>

<style scoped></style>
