<template>
  <div>
    <a href="bills/create" class="btn btn-warning">Create Invoice</a>
    <div>
      <div class="right">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">User ID</th>
              <th scope="col">Customer ID</th>
              <th scope="col" width="140px">Invoice Number</th>
              <th scope="col">Due Date</th>
              <th scope="col">Payment Term</th>
              <th scope="col">Currency</th>
              <th scope="col">Type</th>
              <th scope="col">Actions</th>
              <th scope="col">PDF</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="invoice in invoices.data" :key="invoice.id">
              <td>{{ invoice.user_id }}</td>
              <td>{{ invoice.customer_id }}</td>
              <td>{{ invoice.invoice_number }}</td>
              <td>{{ invoice.due_date }}</td>
              <td>{{ invoice.payment_term }}</td>
              <td>{{ invoice.currency }}</td>
              <td>{{ invoice.type }}</td>

              <router-link :to="`/invoices/show/${invoice.id}`" class="custom-btn custom-btn-warning">Show</router-link>
              <router-link :to="`/invoices/edit/${invoice.id}`" class="custom-btn custom-btn-info">Edit</router-link>
              <button @click="confirmDelete(invoice.id)" type="button" class="custom-btn custom-btn-success">
                Delete
              </button>

              <td>
                <button class="btn btn-success" @click="downloadPDF(invoice.id)">Generate PDF</button>
              </td>

            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import jsPDF from 'jspdf';

export default {
  data() {
    return {
      invoices: [],
    };
  },
  methods: {
    async fetchInvoices() {
      try {
        const response = await axios.get('/api/invoices');
        this.invoices = response.data;
      } catch (error) {
        console.error('Error fetching invoices:', error);
      }
    },
    async confirmDelete(invoiceId) {
      const shouldDelete = confirm('Are you sure you want to delete this invoice?');
      if (shouldDelete) {
        try {
          const response = await axios.delete(`/api/invoices/${invoiceId}`);
          console.log('Invoice deleted:', response.data);
          this.fetchInvoices();
        } catch (error) {
          console.error('Error deleting invoice:', error);
        }
      }
    },
    async downloadPDF(invoiceId) {
      const pdfOptions = {
        format: 'a4',
      };
      const doc = new jsPDF();

      try {
        const invoiceResponse = await axios.get(`/api/invoices/${invoiceId}`);
        const invoiceData = invoiceResponse.data;
        const invoice = invoiceData.invoice;
        const invoiceItems = invoiceData.invoiceItems;
        const customer = invoiceData.customer;
        const user = invoiceData.user;

        doc.setFontSize(12);
        const lineHeight = 6; // Distanța verticală între linii
        doc.setLineWidth(1); // Setează grosimea liniei la 1 (sau la valoarea dorită)

        const contentX = 4;
        const contentY = 7;
        const contentWidth = 203;
        const contentHeight = 6 + 6 * lineHeight; // Ajustează în funcție de înălțimea conținutului

        // Setează grosimea liniei pentru textul "Invoice" la 2
        doc.setFont('helvetica', 'bold'); // Setează fontul și stilul fontului la bold
        doc.setFontSize(20); // Setează dimensiunea fontului
        doc.text('Invoice', 83, 16); // Afișează textul "Invoice" cu font bold

        // Reveniți la fontul implicit pentru textul ulterior
        doc.setFont('helvetica', 'normal'); // Restaurează fontul și stilul fontului la normal
        doc.setFontSize(12);  // Afișează textul "Invoice" cu grosimea liniei setată la 2

        // Reveniți la grosimea liniei implicită pentru textul ulterior
        doc.setLineWidth(0.6);

        // Desenează un dreptunghi cu grosimea liniei setată la 1
        doc.rect(contentX, contentY, contentWidth, contentHeight, 'S'); // 'S' înseamnă să-l deseneze și să-l umple cu negru



        // Adaugă textul în interiorul dreptunghiului
        doc.text(`Business Name: ${invoiceData.user.business_name}`, contentX + 4, contentY + 8);
        doc.text(`Vat Number: ${invoiceData.user.vat_number}`, contentX + 4, contentY + 16);
        doc.text(`Address: ${invoiceData.user.address}`, contentX + 4, contentY + 23);
        doc.text(`Contact Name: ${invoiceData.user.contact_name}`, contentX + 4, contentY + 31);
        doc.text(`E-mail: ${invoiceData.user.email}`, contentX + 4, contentY + 39);


        doc.text(`Contact Name: ${invoiceData.customer.contact_name}`, contentX + 130, contentY + 7);
        doc.text(`Company Name: ${invoiceData.customer.company_name}`, contentX + 130, contentY + 15);
        doc.text(`VAT Number: ${invoiceData.customer.vat_number}`, contentX + 130, contentY + 23);
        doc.text(`E-mail: ${invoiceData.customer.email}`, contentX + 130, contentY + 31);
        doc.text(`Due Date: ${invoiceData.due_date}`, contentX + 73, contentY + 26);
        doc.text(`Invoice Number: ${invoiceData.invoice_number}`, contentX + 73, contentY + 20);

        let totalAmount = 0;
        invoiceData.invoice_items.forEach((item, index) => {
          const itemNumber = index + 1;


          doc.text(`Type: ${invoiceData.type}`, 60, 120 + index * 40);
          doc.text(`Currency: ${invoiceData.currency}`, 70, 130 + index * 40);


          doc.text(`Description: ${item.description}`, 20, 140 + index * 40);
          doc.text(`Amount: ${item.amount}`, 20, 150 + index * 40);


          doc.text(`${itemNumber}:`, 10, 140 + index * 40);


          totalAmount += parseFloat(item.amount);
        });


        doc.setFontSize(12);
        doc.text('Total Amount:', 10, 140 + invoiceData.invoice_items.length * 40 + 10);
        doc.text(`${totalAmount.toFixed(2)}`, 20, 150 + invoiceData.invoice_items.length * 40 + 10);

        doc.save(`Invoice${invoiceId}.pdf`);
      } catch (error) {
        console.error('Error generating PDF:', error);
      }
    },
  },
  created() {
    this.fetchInvoices();
  },
};
</script>





  

<style scoped>
@import '@/Assets/Components/invoices.css';
</style>