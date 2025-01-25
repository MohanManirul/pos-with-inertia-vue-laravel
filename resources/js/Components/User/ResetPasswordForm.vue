<script setup>
 import { useForm,usePage,router } from '@inertiajs/vue3';
 const page = usePage();
 const form = useForm({
     password: '',
     cpassword: '',
 })

 const submitForm = () => {
     form.post('/reset-pass',{
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
</script>

<template>
<!-- component -->
<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
  <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Reset Password</h2>

    <form @submit.prevent="submitForm" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input v-model="form.password"
          type="Text"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
        <input v-model="form.cpassword"
          type="Text"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
        />
      </div>

      <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
        Confirm
      </button>
    </form>


  </div>
</div>
</template>

<style scoped>

</style>
