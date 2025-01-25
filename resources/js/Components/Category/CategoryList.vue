<script setup>
import { ref } from "vue";
import { usePage,Link, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });

const page = usePage();
const searchValue = ref();
const searchField = ["category"];
const headers = [
    { text: "No", value: "id" },
    { text: "Category", value: "name", sortable: true },
    { text: "Action", value: "action" },
];

const items = ref(page.props.categories);

const deleteCategory = (id) => {
    let confirm=window.confirm("Are you sure you want to delete this category?");
    if(confirm){
        router.get(`/delete-category?id=${id}`);
        toaster.success("Category deleted successfully");
    }
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
            :rows-per-page="5"
            :headers="headers"
            :items="items"
            :search-value="searchValue"
            :search-field="searchField"
        >
            <template #item-action="{ id }">
                <Link :href="`/category-save-page?id=${id}`"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                >
                    Edit
                </Link>
                <button
                    class="bg-red-500 text-white font-bold py-2 px-4 rounded ml-1"
                    @click="deleteCategory(id)"
                >
                    Delete
                </button>
            </template>
        </EasyDataTable>
        <div class="mt-4">
        <Link :href= "`/category-save-page?id=${0}`" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">Create </Link>
      </div>
    </div>

</template>

<style scoped></style>
