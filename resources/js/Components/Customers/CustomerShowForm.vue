<template>
  <div class="container mt-4">
    <form class="form">
      <h2 class="CustomerName">{{ customer.contact_name }}</h2>
      <div class="row">
        <div class="col-md-5">
          <div class="Com"><strong class="Com">Company Name:</strong></div>
          <div class="Com1">{{ customer.company_name }}</div>
        </div>

        <div class="col-md-5">
          <div class="Con"><strong class="Con">Contact Name:</strong></div>
          <div class="Con1">{{ customer.contact_name }}</div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-5">
          <div class="Email"><strong class="Email">Email:</strong></div>
          <div class="Email1">{{ customer.email }}</div>
        </div>

        <div class="col-md-5">
          <div class="Va"><strong class="Va">VAT Number:</strong></div>
          <div class="Va1">{{ customer.vat_number }}</div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-5">
          <div class="Ty"><strong class="Ty">Type:</strong></div>
          <div class="Ty1">{{ customer.type }}</div>
        </div>
      </div>

      <button @click="goToCustomers" class="btn btn-secondary">Back to Customers</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
    export default {
      data() {
        return {
          customer: {},
        };
      },
      methods: {
        async fetchCustomer(id) {
          try {
            const response = await axios.get(`/api/customers/${id}`);
            this.customer = response.data;
          } catch (error) {
            console.error("Error fetching customer:", error);
          }
        },
        // Method for redirection to "Customers";
        goToCustomers() {
          this.$router.push("/customers");
        },
      },
      created() {
        const customerId = this.$route.params.id;
        this.fetchCustomer(customerId);
      },
    };
</script>

<style scoped>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css');
</style>