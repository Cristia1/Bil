<template>
  <div class="chart1-container">
    <div class="filter1-container">
      <label for="startDate" class="btn btn-primary">Start Data:</label>
      <input type="date" v-model="startDate" id="startDate" class="btn btn-light">
      <label for="endDate" class="btn btn-primary">End Date:</label>
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
      customerData: [],
      startDate: null,
      endDate: null,
    };
  },
  methods: {
    async loadDataAndDrawChart() {
      try {
        const { startDate, endDate } = this;
        const response = await axios.get('/api/dashboard', {
          params: {
            customer_name: this.invoiceData,
            start_date: startDate,
            end_date: endDate,
          },
        });
        if (response.status === 200) {
          this.invoiceData = response.data.invoiceData || [];
          this.drawChart();
        } else {
          console.error('Eroare la extragerea datelor de la backend.');
        }
      } catch (error) {
        console.error('Eroare la extragerea datelor de la backend:', error);
      }
    },

    drawChart() {
      if (this.chart) {
        this.chart.destroy();
      }

      const ctx = this.$refs.canvas.getContext('2d');
      const chartOptions = {
        responsive: false, 
        maintainAspectRatio: false,
        scales: {
          x: { display: true },
          y: { display: true },
        },
      };

      try {
        const labels = this.invoiceData.map(item => item.date);
        const dataValues = this.invoiceData.map(item => item.count);
        const chartData = {
          labels: labels,
          datasets: [
            {
              label: 'Customer',
              data: dataValues,
              fill: false,
              borderColor: 'blue',
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
  }
};
</script>
<style scoped>
.chart1-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.filter-container {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 10px; 
}

.my-chart-canvas {
  width: 400px;
  height: 300px;
}
.chart-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 0 20px;
}

.filter1-container {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 10px;
}

.my-chart-canvas {
  width: 50%;
  height: 300px;
}
</style>