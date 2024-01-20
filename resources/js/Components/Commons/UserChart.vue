<template>
  <div class="container mt-5">
    <div class="row">
      <div class="TextuserChart">
        <h3>Users</h3>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-12 text-center">
        <div class="userChart">
          <div class="UserCustoChart" :class="{ 'custom-height': maxValue > 0 }">
            {{ userCount }}
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
      userCount: 0,
      maxValue: 0,
    };
  },
  mounted() {
    this.loadDataAndDrawChart();
  },
  methods: {
    async loadDataAndDrawChart() {
      try {
        const response = await axios.get('/api/dashboard');
        if (response.status === 200) {
          this.userCount = response.data.UserData.length;
          this.maxValue = Math.ceil(this.userCount / 10) * 10;
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
