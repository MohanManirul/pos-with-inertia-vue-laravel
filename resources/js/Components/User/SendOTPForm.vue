<script setup>
import { Link, useForm,router,usePage } from '@inertiajs/vue3';

const page = usePage();
const form = useForm({
    email: '',
})

function submitForm() {
    if(form.email==''){
        alert('Email is required');
    }else{
        form.post('/send-otp',{
            onSuccess: () => {
                if(page.props.flash.status===true){
                    router.get("/verify-otp-page")
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
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Send OTP</h2>

    <form @submit.prevent="submitForm" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input v-model="form.email"
          type="email"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
        />
      </div>

      <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
        Next
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

