<script setup>
import { Link, router, useForm, usePage } from "@inertiajs/vue3";
import { set } from "nprogress";
import { reactive } from "vue";
import ImageUpload from "./ImageUpload.vue";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });


const page = usePage();
const status = reactive({
    title: "Create Product",
    buttonTitle: "Create Product",
});
let params = new URLSearchParams(window.location.search);
let id = params.get("id");

const form = useForm({
    name: "",
    price: "",
    qty: "",
    img_url: "",
    category_id: "",
    id:id,
});



let URL = "/create-product";
if (id !== 0 && page.props.product !== null) {
    status.title = "Update Product";
    status.buttonTitle = "Update Product";
    URL = "/update-product";
    form.name = page.props.product.name;
    form.price = page.props.product.price;
    form.qty = page.props.product.unit;
    form.img_url = page.props.product.img_url;
    form.category_id = page.props.product.category_id;

}




    const submitForm = () => {

        form.post(URL, {
            preserveScroll: true,
            onSuccess: () => {
                if (page.props.flash.status === true) {
                    toaster.success(page.props.flash.message);
                        setTimeout(() => {
                            router.get("/product-page");
                        },500);
                } else {
                    toaster.error(page.props.flash.message);
                }
            },
        });
    };


</script>

<template>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6 text-center">{{ status.title }}</h1>
        <form
            @submit.prevent="submitForm"
            class="w-full max-w-sm mx-auto bg-white p-8 rounded-md shadow-md"
        >
        <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="price"
                    >Select Category</label
                >
                <select v-model="form.category_id"  name="category" id="category" class="border text-sm rounded-lg block w-full p-2.5">
                  <option value="" selected>select category</option>
                  <option v-for="page in page.props.categories" :key="page.id" :value="page.id">{{ page.name }}</option>
                </select>
            </div>
            <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="name"
                    >Name</label
                >
                <input
                    v-model="form.name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
                    type="text"
                    id="name"
                    name="name"
                />
                <input type="text" v-model="form.id" hidden name="id" />
            </div>
            <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="price"
                    >Price</label
                >
                <input
                    v-model="form.price"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
                    type="text"
                    id="price"
                    name="price"
                />
            </div>
            <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="qty"
                    >Qty</label
                >
                <input
                    v-model="form.qty"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
                    type="text"
                    id="qty"
                    name="qty"
                />
            </div>
            <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="img_url"
                    >Image</label
                >

                <ImageUpload :productImage="form.img_url"
                @image="(e) => (form.img_url = e)"/>
            </div>

            <button @summit.prevent="submitForm"
                type="submit"
                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-2.5 rounded-lg transition-colors"
            >
                {{ status.buttonTitle }}
            </button>
        </form>
    </div>
</template>

<style scoped></style>
