<script setup>
import { ref } from "vue";
const props = defineProps({
    show: Boolean,
    customer: Object,
});

const emit = defineEmits(["update:show"]);

const printInvoice = () => {
    const printContent = document.getElementById("print-invoice").innerHTML;

    const printDiv = document.createElement("div");
    printDiv.innerHTML = printContent;

    printDiv.style.position = "absolute";
    printDiv.style.top = "0";
    printDiv.style.left = "0";
    printDiv.style.right = "0";
    printDiv.style.bottom = "0";
    printDiv.style.height = "100%";
    printDiv.style.width = "100%";
    printDiv.style.backgroundColor = "white";
    printDiv.style.zIndex = "9999";
    document.body.appendChild(printDiv);
    window.print();

    document.body.removeChild(printDiv);
};
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 flex justify-center items-center bg-gray-500 bg-opacity-50 z-50"
    >
        <div
            class="bg-white border rounded-lg shadow-lg p-3 flex basis-auto w-1/2"
        >
            <div class="w-full">
                <div id="print-invoice">
                    <div class="flex justify-between">
                        <h1 class="text-sm font-bold">Invoice</h1>
                        <div class="text-gray-700">
                            <div>
                                {{ new Date().toISOString().slice(0, 10) }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold mb-4">Bill To:</h2>
                        <p class="text-gray-700 mb-2 font-bold">
                            Name: {{ props.customer.customer.name }}
                        </p>
                        <p class="text-gray-700 font-bold">
                            Email: {{ props.customer.customer.email }}
                        </p>
                        <p class="text-gray-700 font-bold">
                            User Id: {{ props.customer.customer.id }}
                        </p>
                    </div>
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                            <tr
                                class="text-center"
                                v-for="(product, index) in props.customer
                                    .invoice_products"
                                :key="index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ product.product.name }}</td>
                                <td>{{ product.qty }}</td>
                                <td>{{ product.product.price }}</td>
                                <td>{{ product.sale_price }}</td>
                            </tr>
                        </thead>
                        <tbody id="invoiceProduct"></tbody>
                    </table>
                    <div class="mt-6">
                        <p class="font-bold">
                            Total: {{ props.customer.total }}
                        </p>
                        <p class="font-bold">
                            Payable: {{ props.customer.payable }}
                        </p>
                        <p class="font-bold">Vat: {{ props.customer.vat }}</p>
                        <p class="font-bold">
                            Discount: {{ props.customer.discount }}
                        </p>
                    </div>
                </div>
                <div class="w-full flex justify-end items-end mt-[200px]">
                    <button
                        @click="$emit('update:show', false)"
                        class="bg-red-500 text-white m-2 px-4 py-2 rounded-md hover:bg-red-600"
                    >
                        Close
                    </button>
                    <button
                        @click="[printInvoice(), $emit('update:show', false)]"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 m-2"
                    >
                        Print
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
