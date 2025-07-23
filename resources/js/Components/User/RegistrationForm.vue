<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
const page = usePage();

const form = useForm({
    name: '',
    email: '',
    mobile: '',
    password: '',
})
 
const submitForm = () => {
    if(form.name==''){
   alert('Name is required');
}else if(form.email==''){
    alert('Email is required');

}else if(form.mobile==''){
    alert('Mobile is required');

}else if(form.password==''){
    alert('Password is required');

}else{
    form.post('/user-registration',{
        onSuccess: () => {
            if(page.props.flash.status===true){
                router.get("/login-page")
            }
            else {
                alert(page.props.flash.message)
            }
        }
    });

}

}

</script>

<template>
<!-- component -->

  <div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Registration Form</h1>
    <form @submit.prevent="submitForm"  class="w-full max-w-sm mx-auto bg-white p-8 rounded-md shadow-md">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
        <input v-model="form.name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="text" id="name" name="name" placeholder="John Doe">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
        <input v-model="form.email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="email" id="email" name="email" placeholder="john@example.com">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="mobile">Mobile</label>
        <input v-model="form.mobile" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="text" id="mobile" name="mobile">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
        <input v-model="form.password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="password" id="password" name="password">
      </div>

      <button type="submit"
        class="w-full bg-indigo-500 text-white text-sm font-bold py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-300"
        >Register</button>
    </form>

     <div class="mt-6 text-center text-sm text-gray-600">
      Wait ! I've an account
      <Link href="/" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign In</Link>      
    </div>
  </div>

</template>

<style scoped>

</style>
