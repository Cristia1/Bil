 <template>
    <div class="CustomerChart">
      <div class="CustomerFilter">
        <label for="startDate" class="btn btn-success">Start Data:</label>
        <input type="date" v-model="startDate" id="startDate" class="btn btn-light">
        <label for="endDate" class="btn btn-success">End Date:</label>
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
              customer_name: this.customerName,
              start_date: startDate,
              end_date: endDate,
            },
          });
          if (response.status === 200) {
            this.customerData = response.data.customerData || [];
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
          const labels = this.customerData.map(item => item.date);
          const dataValues = this.customerData.map(item => item.count);
          const chartData = {
            labels: labels,
            datasets: [
              {
                label: 'Customer',
                data: dataValues,
                fill: false,
                borderColor: 'green',
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
  .CustomerChart {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .my-chart-canvas {
    width: 500px;
    height: 300px;
    margin-left: 670px;
  }
  
  .CustomerFilter {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
    margin-left: 700px;
    margin-top: 10px;
  }
  
  label, input, button {
  font-size: 9px; 
  margin-right: 10px; 
}
  </style>