<template>
    <div class="container my-5">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <form>
            <div class="mb-3">
              <ErrorMessages :errors="[company_nameError]" />
              <label for="company_name" class="form-label">Company Name<span class="text-danger">*</span></label>
              <input type="text" class="form-control" v-model="company_name" placeholder="Enter company name" @input="validateForm">
            </div>
  
            <div class="mb-3">
              <ErrorMessages :errors="[contact_nameError]" />
              <label for="contact_name" class="form-label">Contact Name<span class="text-danger">*</span></label>
              <input type="text" class="form-control" v-model="contact_name" placeholder="Enter contact name" @input="validateForm">
            </div>
  
            <div class="mb-3">
              <ErrorMessages :errors="[emailError]" />
              <label for="email" class="form-label">E-mail<span class="text-danger">*</span></label>
              <input type="email" class="form-control" v-model="email" placeholder="Enter email" @input="validateForm">
            </div>
  
            <div class="mb-3">
              <ErrorMessages :errors="[vat_numberError]" />
              <label for="vat_number" class="form-label">VAT Number<span class="text-danger">*</span></label>
              <input type="number" class="form-control" v-model="vat_number" placeholder="Enter VAT number" @input="validateForm">
            </div>
  
            <div class="mb-3">
              <ErrorMessages :errors="[typeError]" />
              <label for="type" class="form-label">Type<span class="text-danger">*</span></label>
              <select class="form-select" v-model="type" @blur="validateForm">
                <option value="Business">Business</option>
                <option value="Individual">Individual</option>
              </select>
            </div>
  
            <div class="mb-3 text-end">
              <button type="button" class="btn btn-danger" @click="addCustomer">Add Customer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  


<script>
import axios from 'axios';
import ErrorMessages from '../Commons/ErrorMessages.vue';


    export default {
        components: {
            ErrorMessages,
        },
        data() {
            return {
                showTable: true,
                company_name: '',
                contact_name: '',
                email: '',
                vat_number: '',
                type: '',
                company_nameError: '', 
                contact_nameError: '', 
                emailError: '', // 
                vat_numberError: '', 
                typeError: '', 
                formErrors: [],
            };
        },
        methods: {
        validateForm() {
            this.formErrors = [];

            const fields = {
                company_name: 'Company Name',
                contact_name: 'Contact Name',
                email: 'E-mail',
                vat_number: 'VAT Number',
                type: 'Type',
            };
            
            for (const field in fields) {
                if (!this[field]) {
                    this[`${field}Error`] = `${fields[field]} field is required`; 
                    this.formErrors.push(this[`${field}Error`]);
                } else {
                    this[`${field}Error`] = ''; 
                }
            }
        },
            async addCustomer() {
                try {
                    const csrfMeta = document.head.querySelector('meta[name="csrf-token"]');
                    const csrfToken = csrfMeta ? csrfMeta.content : null;

                    const headers = {
                        'Content-Type': 'application/json',
                    };

                    if (csrfToken) {
                        headers['X-CSRF-TOKEN'] = csrfToken;
                    }

                    const response = await axios.post("/api/customers", {
                        company_name: this.company_name,
                        contact_name: this.contact_name,
                        email: this.email,
                        vat_number: this.vat_number,
                        type: this.type,
                    }, {
                        headers: headers,
                    });

                    if (response.status === 200) {
                        console.log("Customer created successfully!");
                        this.$router.push("/customers");
                    } else {
                        console.error("Error creating customer:");
                    }
                } catch (error) {
                    console.error("Error creating customer:", error);
                }
            },
        },
    };
</script>