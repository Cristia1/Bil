<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h2 class="text-center">{{ customer.contact_name }}</h2>
          </div>
          <div class="card-body">
            <form class="EditForm">
              <div class="mb-3">
                <label for="company_name" class="form-label">Company Name:</label>
                <input type="text" class="form-control" id="company_name" v-model="customer.company_name" />
              </div>

              <div class="mb-3">
                <label for="contact_name" class="form-label">Contact Name:</label>
                <input type="text" class="form-control" id="contact_name" v-model="customer.contact_name" />
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" class="form-control" id="email" v-model="customer.email" />
              </div>

              <div class="mb-3">
                <label for="vat_number" class="form-label">VAT Number:</label>
                <input type="text" class="form-control" id="vat_number" v-model="customer.vat_number" />
              </div>

              <div class="mb-3">
                <label for="type" class="form-label">Type:</label>
                <select class="form-select" id="type" v-model="customer.type">
                  <option value="Business">Business</option>
                  <option value="Individual">Individual</option>
                </select>
              </div>

              <div class="text-center">
                <button @click.prevent="saveChanges" class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  


<script>
import axios from "axios";

export default {
    
    data() {
        return {
            customer: {
                id: null,
                company_name: "",
                contact_name: "",
                email: "",
                vat_number: "",
                type: "",
            },
        };
    },
    methods: {  // fecth the Customer
        async fetchCustomer(id) {
            try {
                const response = await axios.get(`/api/customers/${id}`);
                this.customer = response.data;
            }
            catch (error) {
                console.error("Error fetching customer:", error);
            }
        },
        async saveChanges() {
            try {
                const response = await axios.put(`/api/customers/${this.customer.id}`, this.customer);

                this.$router.push("/customers"); //Push to back route
                window.location.href = '/customers';
            }
            catch (error) {
                console.error("Error saving changes:", error);
            }
        },
    },
    created() {
        const customerId = this.$route.params.id;
        if (customerId) {
            this.fetchCustomer(customerId);
        }

    },
};
</script>

<style scoped>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css');
</style>
