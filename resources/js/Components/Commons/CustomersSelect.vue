<template>
    <div class="col-md-13">
        <ErrorMessages :errors="[CustomerdError]" />
            <label class="form-control-label px-3">Customer<span class="text-danger"></span></label>
                <select v-model="selected_customer" class="form-control" @input="validateForm">
                    <option value="" disabled>Select a Customer</option>
                        <option  v-for="customer in customers.data" :key="customer.id" :value="customer.id">
                {{ customer.contact_name }}
            </option>
        </select>
    </div>
</template>


<script>
import axios from 'axios';
import ErrorMessages from '../Commons/ErrorMessages.vue';

    export default {
        components:{
            ErrorMessages,
        },
        props: {
            selected_customer_id: '',
        },
        data() {
            return {
                selected_customer: '',
                customers: [],
                CustomerdError: '',
            };
        },
        watch: {
            selected_customer_id(id) {
                this.selected_customer = id;
            },
        },
        methods: {
            validateForm() {
                this.CustomerdError = ''; 

                // if (!this.selected_customer_id) {
                //     this.CustomerdError = 'The Customer Id field is required.';  
                // } 
            },
            async fetchCustomers() {
                try {
                    const response = await axios.get("/api/customers");
                    this.customers = response.data;


                    if (response.status === 200) {
                        this.customers = response.data;
                    } else {
                        console.error("Error fetching customers:");
                    }
                } catch (error) {
                    console.error("Error fetching customers:", error);
                }
            },
            async fetchCustomerName(id) {
                const customer = this.customers.data.find((c) => c.id === id);
                this.$emit("update:selected-customer-name", customer ? customer.contact_name : "");
            },
        },
        mounted() {
            this.fetchCustomers();
        },
    };
</script>