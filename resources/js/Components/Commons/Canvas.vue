<template>
  <div>
    <canvas ref="Canvas" width="400" height="300"></canvas>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      canvas: null,
    };
  },
  mounted() {
    this.canvas = this.$refs.Canvas;
    this.loadDataAndDrawChart();
  },
  methods: {
    async loadDataAndDrawChart() {
      try {
        const response = await axios.get('/api/dashboard');
        if (response.status === 200) {
          const { userData, customerData, invoiceData } = response.data;
          this.drawChart(userData, customerData, invoiceData);  
        } else {
          console.error('Eroare la preluarea datelor din backend.');
        }
      } catch (error) {
        console.error('Eroare la preluarea datelor din backend:', error);
      }
    },
    drawChart(userData, customerData, invoiceData) {
  if (this.canvas) {
    const ctx = this.canvas.getContext('2d');
    const datasets = [userData, customerData, invoiceData];
    const colors = ['blue', 'green', 'red'];
    const barWidth = 40;
    const spacing = 20;
    const xStart = 50;

    for (let j = 0; j < datasets.length; j++) {
      const data = datasets[j];

      ctx.beginPath();
      ctx.strokeStyle = colors[j % colors.length];
      ctx.lineWidth = 2;

      for (let i = 0; i < data.length; i++) {
        const x = xStart + i * (barWidth + spacing);
        const y = this.canvas.height - data[i];

        // Desenează linia
        if (i === 0) {
          ctx.moveTo(x, y);
        } else {
          ctx.lineTo(x, y);
        }

        // Adaugă text la fiecare coloană
        ctx.fillStyle = colors[j % colors.length];
        ctx.fillText(`${data[i]}`, x + barWidth / 2 - 10, y - 5);
      }

      // Adaugă text pentru tipul de date
      ctx.fillStyle = colors[j % colors.length];
      const textY = this.canvas.height - data[data.length - 1] - 15;
      ctx.fillText(`${j === 0 ? 'User' : (j === 1 ? 'Customer' : 'Invoice')}`, x + barWidth / 2 - 30, textY);
      ctx.stroke();
    }
  } else {
    console.error('Ref-ul pentru canvas nu este definit.');
  }
}

  }
};
</script>
