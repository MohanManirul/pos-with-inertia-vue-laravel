<script setup>
import { reactive } from 'vue';
import { useForm,usePage,router } from '@inertiajs/vue3';
import {createToaster} from "@meforma/vue-toaster";
const toaster = createToaster({});
const page = usePage();
const status=reactive({
    title:'Create Customer',
    buttonTitle:'Create Customer',
})
let params=new URLSearchParams(window.location.search);
let id=params.get('id');

const form = useForm({
    name: '',
    email: '',
    mobile: '',
    id: id
})

let list = page.props.customer;

let URL='/create-customer';
if(id !==0 && list !== null ){
    URL='/update-customer';
    form.name=list.name;
    form.email=list.email;
    form.mobile=list.mobile;
    status.title='Update Customer';
    status.buttonTitle='Update Customer';
}

const submitForm = () => {
    form.post(URL,{
        preserveScroll: true,
        onSuccess: () => {
            if(page.props.flash.status===true){
                toaster.success(page.props.flash.message);
                setTimeout(() => {
                    router.get("/customer-page");
                },500);
            }
            else {
                toaster.error(page.props.flash.message)
            }
        }
    });
}
</script>

<template>
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">{{ status.title }}</h1>
    <form @submit.prevent="submitForm"  class="w-full max-w-sm mx-auto bg-white p-8 rounded-md shadow-md">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
        <input v-model="form.name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="text" id="name" name="name">
          <input type="text" v-model="form.id" hidden  name="id">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
        <input v-model="form.email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="email" id="email" name="email">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="mobile">Mobile</label>
        <input v-model="form.mobile" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="text" id="mobile" name="mobile">
      </div>

      <button type="submit"
        class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-2.5 rounded-lg transition-colors"
        > {{ status.buttonTitle }} </button>
    </form>
  </div>
</template>

<style scoped>

</style>
