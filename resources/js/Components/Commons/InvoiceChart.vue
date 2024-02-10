<template>
  <div class="InvoiceChart">
    <div class="InvoiceFilter">
      <label for="startDate" class="btn btn-primary">Start Date:</label>
      <input type="date" v-model="startDate" id="startDate" class="btn btn-light">
      <label for="endDate" class="btn btn-primary">End Date:</label>
      <input type="date" v-model="endDate" id="endDate" class="btn btn-light">
      <button @click="loadDataAndDrawChart" class="btn btn-light">Send</button>
    </div>
    <div class="ChartContainer">
      <canvas ref="canvas" class="my-chart-canvas"></canvas>
    </div>
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
              label: 'Invoice',
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
.InvoiceChart {
  position: fixed;
  top: 79px; 
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-left: 100px;
}

.Invoicefilter {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  margin-right: 10px; 
}

.my-chart-canvas {
  width: 510px;
  height: 300px;
}

label, input, button {
  font-size: 9px; 
  margin-right: 10px;
}
</style>