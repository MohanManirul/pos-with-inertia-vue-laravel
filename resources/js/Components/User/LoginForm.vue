<script setup>
import { useForm,router,usePage, Link } from '@inertiajs/vue3';

const page = usePage();
const form = useForm({
    email: 'superadmin@gmail.com',
    password: '12345678',
})

function submitForm() {
    if(form.email==''){
        alert('Email is required');
    }else if(form.password==''){
        alert('Password is required');
    }else{
        form.post('/user-login',{
            onSuccess: () => {
                if(page.props.flash.status===true){
                    router.get("/dashboard-page")
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
<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
  <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sign In</h2>

    <form @submit.prevent="submitForm" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input 
          v-model="form.email"
          :value="form.email"
          type="email"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input 
          v-model="form.password"
          :value="form.password"
          type="password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"

        />
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center">
          <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"/>
          <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </label>
        <Link href="/send-otp-page" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot password?</Link>
      </div>

      <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
        Sign In
      </button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
      Don't have an account?
      <Link href="/registration-page" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign up</Link>      
    </div>
  </div>
</div>
</template>

<style scoped>

</style>
