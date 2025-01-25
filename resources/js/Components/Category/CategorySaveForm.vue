<script setup>
import { useForm,Link,router,usePage } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });

const formStatus=reactive({
    title:'Create Category',
    buttonTitle:'Create Category',
})

const page = usePage();

const form = useForm({
    name: '',
    id: ''
})

let params=new URLSearchParams(window.location.search);
let id=params.get('id');
let list = page.props.category;

let URL='/create-category';
if(id !==0 && list !== null ){
    URL='/update-category';
    form.name=list.name;
    form.id=id;
    formStatus.title='Update Category';
    formStatus.buttonTitle='Update Category';
}

const submitForm = () => {
    form.post(URL, {
        preserveScroll: true,
        onSuccess: () => {
            if(page.props.flash.status===true){
                toaster.success(page.props.flash.message);
                setTimeout(() => {
                    router.get("/category-page");
                },500);
            }
            else {
                toaster.error(page.props.flash.message)
            }
        }
    })
}

</script>

<template>
    <!-- component -->
    <div class="h-screen bg-gray-100 flex  justify-center p-4">
      <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8 h-[250px] mt-[200px]">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center"> {{ formStatus.title }}</h2>

        <form @submit.prevent="submitForm" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
            <input v-model="form.name"
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
            />
            <input type="text" v-model="form.id" hidden>
          </div>

          <button class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-2.5 rounded-lg transition-colors">
            {{ formStatus.buttonTitle }}
          </button>
        </form>
      </div>
    </div>
    </template>

<style scoped>

</style>
