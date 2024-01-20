<template>
  <div class="container mt-5">
    <div class="row">
      <div class="TextInvoiceChart">
        <h3>Invoices</h3>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-12 text-center">
        <div class="InvoiceChart">
          <div class="InvoiceCustoChart" :class="{ 'custom-height': maxValue > 0 }">
            {{ invoiceCount }}
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
      invoiceCount: 0,
      maxValue: 0,
    };
  },
  mounted() {
    this.loadDataAndDrawChart();
  },
  methods: {
    async loadDataAndDrawChart() {
      try {
        const response = await axios.get('/api/invoices');
        if (response.status === 200) {
          this.invoiceCount = response.data.data.length;
          this.maxValue = Math.ceil(this.invoiceCount / 10) * 10;
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
