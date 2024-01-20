<template>
  <div class="container mt-5">
    <div class="row">
      <div class="TextCustomerChart">
        <h3>Customers</h3>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-12 text-center">
        <div class="CustomerChart">
          <div class="CustoChart" :class="{ 'custom-height': maxValue > 0 }">
            {{ customerCount }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      customerCount: 0,
      maxValue: 0,
    };
  },
  mounted() {
    this.loadDataAndDrawChart();
  },
  methods: {
    async loadDataAndDrawChart() {
      try {
        const response = await axios.get('/api/customers');
        if (response.status === 200) {
          this.customerCount = response.data.data.length;
          this.maxValue = Math.ceil(this.customerCount / 10) * 10;
        } else {
          console.error('Error retrieving data from backend.');
        }
      } catch (error) {
        console.error('Error retrieving data from backend:', error);
      }
    },
  },
};
</script>

<style scoped>
@import '@/Assets/Components/extra.css';
</style>
