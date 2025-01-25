<template>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="min-h-[500px] border border-gray-200 rounded-md px-4 py-2">
            <h1 class="text-lg font-bold text-gray-700 text-end">Invoice</h1>
            <h1 class="text-lg font-bold text-gray-700 text-end">{{ new Date().toISOString().slice(0, 10) }}</h1>

            <div>
                <h1 class="text-lg font-bold text-gray-700 "> Bill To </h1>
                <h1 class="text-sm font-bold text-gray-700 "> Name: {{ customer.name }} </h1>
                <h1 class="text-sm font-bold text-gray-700 "> User Id: {{ customer.id }}</h1>
            </div>
            <div>
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                        <tbody>
                            <tr v-if="productList.length > 0" v-for="(product,index) in productList" :key="index" class="text-center">
                                <td> {{ index+1 }} </td>
                                <td> {{ product['name'] }} </td>
                                <td>{{ product['unit'] }}</td>
                                <td> {{ product['price'] }}</td>
                                <td>
                                    <button @click="removeQty(product.id)" class="text-red-600 text-[20px] p-2">-</button>
                                    <button @click="addQty(product.id)" class="text-green-600 text-xl">+</button>
                                    <button @click="removeProduct(index)" class="text-red-600 ml-2">Remove</button>
                                </td>
                            </tr>
                        </tbody>
                </table>
             <div class="mt-10">
                <h1> Total:  {{ calculate.total }} </h1>
                <h1> Payable:  {{ calculate.payable }}  </h1>
                <h1> Vat(%): <span><input @click="calculateTotal()" v-model="calculate.vatP" type="number" class="w-[80px] border border-gray-200 ml-5" min="0" value="0"></span></h1>
                <h1> Vat:  {{ calculate.vat }} </h1>
                <h1> Discount(%): <span><input @click="calculateTotal()" v-model="calculate.discountP" type="number" class="w-[80px] border border-gray-200" min="0" value="0"></span></h1>
                <h1> Discount:  {{ calculate.discount }} </h1>
             </div>
             <div>
                <button @click="createInvoice()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Confirm</button>
            </div>
            </div>
        </div>

        <div class="max-h-[500px] border border-gray-200 rounded-md">
            <input
                v-model="searchProduct"
                type="text"
                class="mb-2 px-2 py-1 w-[300px] border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                placeholder="Search...."
            />
            <EasyDataTable
                buttons-paginations
                alternating
                :items="products"
                :headers="productsHeaders"
                :rows-per-page="10"
                :search-value="searchProduct"
                :seach-field="productSearchField"
            >
                <template #item-img_url="{ img_url }">
                    <img :src="img_url" class="w-10 h-10" />
                </template>
                <template #item-action="{ id,img_url,name,price,unit }">
                    <button
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded"
                        @click="addProduct(id,img_url,name,price,unit)"
                    >
                        Add
                    </button>
                </template>
            </EasyDataTable>
        </div>

        <div class="max-h-[500px] border border-gray-200 rounded-md">
            <input
                v-model="searchCustomer"
                type="text"
                class="mb-2 px-2 py-1 w-[300px] border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                placeholder="Search...."
            />
            <EasyDataTable
                buttons-paginations
                alternating
                :items="customers"
                :headers="customersHeaders"
                :rows-per-page="10"
                :search-value="searchCustomer"
                :seach-field="customerSearchField"
            >
                <template #item-action="{name,id }">
                    <button
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded"
                        @click="addCustomer(name,id)"
                    >
                        Add
                    </button>
                </template>
            </EasyDataTable>
        </div>
    </div>
</template>

<script setup>
import { ref ,reactive} from "vue";
import { Link, usePage, useForm, router } from "@inertiajs/vue3";
const page = usePage();
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });

const productsHeaders = [
    { text: "No", value: "id" },
    { text: "Image", value: "img_url" },
    { text: "Name", value: "name", sortable: true },
    { text: "Price", value: "price", sortable: true },
    { text: "Qty", value: "unit" },
    { text: "Action", value: "action" },
];
const searchCustomer = ref();
const customerSearchField = ref(["name"]);
const searchProduct = ref();
const productSearchField = ref(["name"]);

const customers = ref(page.props.customers);
const products = ref(page.props.products);

const customersHeaders = [
    { text: "No", value: "id" },
    { text: "Name", value: "name", sortable: true },
    { text: "Mobile", value: "mobile" },
    { text: "Email", value: "email" },
    { text: "Action", value: "action" },
];

const productList=ref([]);
const addProduct = (id,img_url,name,price,productUnit) => {

   const product={
       id:id,
       img_url:img_url,
       name:name,
       price:price,
       unit:1,
       exitsQty:productUnit-1,
       productPrice:price
   };
   productList.value.push(product);
   calculateTotal();
};


const removeProduct = (index)=>{
    productList.value.splice(index,1);
    calculateTotal();
}

const addQty = (id)=>{
    const product = productList.value.find((product) => product.id === id);
    if(product.exitsQty>=product.unit){
        product.unit++;
        product.price=parseFloat(product.productPrice)*parseFloat(product.unit);
    }

    calculateTotal();
}

const removeQty = (id)=>{
    const product = productList.value.find((product) => product.id === id);
    if(product.unit>1){
        product.unit--;
        product.price-=product.productPrice;
    }
    calculateTotal();

}

const customer=reactive({
    name:'',
    id:''
})

const addCustomer=(name,id)=>{
    customer.name=name;
    customer.id=id;
}

const calculate=reactive({
    total:0,
    discountP:0,
    discount:0,
    vatP:0,
    vat:0,
    payable:0
})

const calculateTotal=()=>{
    calculate.total=0;
    calculate.discount=0;
    calculate.vat=0;
    calculate.payable=0;
    productList.value.forEach((product)=>{
    calculate.total+=parseFloat(product.price);

    });
    if(calculate.discountP==0 && calculate.vatP==0){
        calculate.total=parseFloat(calculate.total).toFixed(2);

    }else if(calculate.discountP>0 || calculate.vatP>0){
        calculate.discount=((calculate.total*parseFloat(calculate.discountP))/100).toFixed(2);
        calculate.total-=calculate.discount;
        calculate.vat=((calculate.total*parseFloat(calculate.vatP))/100).toFixed(2);

    }
    calculate.payable=(parseFloat(calculate.total)+parseFloat(calculate.vat)).toFixed(2);
}

const form=useForm({
    cus_id:'',
    products:'',
    total:'',
    discount:'',
    vat:'',
    payable:'',
})


const createInvoice=()=>{
    form.cus_id=customer.id;
    form.products=productList.value;
    form.total=calculate.total;
    form.discount=calculate.discount;
    form.vat=calculate.vat;
    form.payable=calculate.payable;

    form.post('create-invoice',{
        onSuccess: () => {

            if(page.props.flash.status===true){
                form.reset();
                productList.value=[];
                calculate.total=0;
                calculate.discount=0;
                calculate.discountP=0;
                calculate.vat=0;
                calculate.vatP=0;
                calculate.payable=0;
                toaster.success(page.props.flash.message);
                setTimeout(() => {
                    router.get("/invoice-page");
                },500);
            }
            else {
                toaster.error(page.props.flash.message)

            }
        }
    })
}


</script>
