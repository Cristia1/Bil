<template>
  <CustomerChart />
  <br>
  <InvoiceChart />
  <br>
  <UserChart />
</template>

<script>
import Axios from 'axios';
import CustomerChart from "../Commons/CustomerChart.vue";
import InvoiceChart from '../Commons/InvoiceChart.vue';
import UserChart from '../Commons/UserChart.vue';

export default {
  components: {
    CustomerChart,
    InvoiceChart,
    UserChart,
  },
};
</script>