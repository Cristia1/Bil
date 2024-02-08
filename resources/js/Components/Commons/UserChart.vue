<template>
    <div>
      <canvas ref="canvas" width="10" height="200"></canvas>
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
                    this.UserData = response.data.UserData || [];

                    if (this.UserData.length > 0) {
                        this.UserData.forEach(item => {
                            const createdAt = new Date(item.created_at);
                            const formattedCreatedAt = `${createdAt.toLocaleDateString()} ${createdAt.getHours().toString().padStart(2, '0')}:${createdAt.getMinutes().toString().padStart(2, '0')}:${createdAt.getSeconds().toString().padStart(2, '0')}`;
                            item.formatted_created_at = formattedCreatedAt;
                        });
                    }

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
        responsive: true,
        maintainAspectRatio: false,
        scales: { 
            x: { display: true },
            y: { display: true },
        }
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