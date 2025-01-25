<script setup>
import { Link, useForm, router,usePage } from '@inertiajs/vue3';
const page = usePage();
const form = useForm({
    otp: '',
})

function submitForm() {
    form.post('/verify-otp', {
        preserveScroll: true,
        onSuccess: () => {
            if(page.props.flash.status===true){
                router.get("/reset-password-page")
            }
            else {
                alert(page.props.flash.message)
            }
        }
    })
}
</script>

<template>
<!-- component -->
<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
  <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Verify OTP</h2>

    <form @submit.prevent="submitForm" class="space-y-4">
      <div>
        <input v-model="form.otp"
          type="text"
          class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
        />
      </div>

      <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
        Next
      </button>
    </form>

  </div>
</div>
</template>

<style scoped>

</style>

