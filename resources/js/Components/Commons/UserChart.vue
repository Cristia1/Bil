<template>
    <div class="User">
      <div class="User1">
        <label for="startDate" class="btn btn-danger">Start Date:</label>
        <input type="date" v-model="startDate" id="startDate" class="btn btn-light">
        <label for="endDate" class="btn btn-danger">End Date:</label>
        <input type="date" v-model="endDate" id="endDate" class="btn btn-light">
        <button @click="loadDataAndDrawChart" class="btn btn-light">Send</button>
      </div>
      <canvas ref="canvas" class="my-chart-canvas"></canvas>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Chart from 'chart.js/auto';
  
  export default {
    data() {
      return {
        chart: null,
        UserData: [],
        startDate: null,
        endDate: null,
      };
    },
    mounted() {
      this.loadDataAndDrawChart();
    },
    methods: {
      async loadDataAndDrawChart() {
        try {
          const response = await axios.get('/api/dashboard', {
            params: {
              startDate: this.startDate,
              endDate: this.endDate,
            },
          });
  
          if (response.status === 200) {
            this.UserData = response.data.UserData || [];
            this.drawChart();
          } else {
            console.error('Error fetching data from the backend.');
          }
        } catch (error) {
          console.error('Error fetching data from the backend:', error);
        }
      },
  
      drawChart() {
        const ctx = this.$refs.canvas.getContext('2d');
        const chartOptions = {
          responsive: false,
          maintainAspectRatio: false,
          scales: {
            x: { display: true },
            y: { display: true },
          },
        };
  
        if (this.chart) {
          this.chart.destroy();
        }
  
        try {
          const labels = this.UserData.map(item => item.created_at);
          const dataValues = this.UserData.map(item => item.id);
  
          const chartData = {
            labels: labels,
            datasets: [
              {
                label: 'Users',
                data: dataValues,
                fill: false,
                borderColor: 'red',
                tension: 0.1,
              },
            ],
          };
  
          this.chart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: chartOptions,
          });
  
          console.log('Chart drawn successfully.');
        } catch (error) {
          console.error('Error drawing the chart:', error);
        }
      },
  
      beforeDestroy() {
        if (this.chart) {
          this.chart.destroy();
        }
      },
    },
  };
  </script>
  

  <style scoped>
.User {
  position: relative;
  margin-right: -310px;
  margin-top: -0px;
}

.User1 {
  position: absolute;
  top: -50px; 
  left: 400px; 
  display: flex;
  align-items: center; 
}

.my-chart-canvas {
  width: 540px;
  height: 8px;
  margin-top: 10px; 
  margin-left: 290px;
}

label, input, button {
  font-size: 9px; 
  margin-right: 10px; 
}
</style>