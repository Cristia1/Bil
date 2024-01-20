import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
// import router from './router';

// Import components
import MainLayout from "../Layouts/Navbar/MainLayout.vue";
import CustomerList from "../Components/Customers/CustomerList.vue";
import CustomerForm from "../Components/Customers/CustomerForm.vue";
import CustomerEditForm from "../Components/Customers/CustomerEditForm.vue";
import CustomerShowForm from "../Components/Customers/CustomerShowForm.vue";
// End components


// Import invoices
import InvoiceEdit from "../Components/Invoices/InvoiceEdit.vue";
import InvoiceForm from "../Components/Invoices/InvoiceForm.vue";
import InvoiceList from "../Components/Invoices/InvoiceList.vue";
import InvoiceShow from "../Components/Invoices/InvoiceShow.vue";
// End invoices


// Inport Dashboard
import Dashboard from "../Components/Dashboard/Dashboard.vue";
// End Dashboard


// Inport Components Reusabile
import UserProfile from "../Components/Commons/UserProfile.vue";
import Home from "../Components/Commons/Home.vue";
import Logout from "../Components/Commons/Logout.vue";
import InvoiceChart from "../Components/Commons/InvoiceChart.vue";
import CustomerChart from "../Components/Commons/CustomerChart.vue";
import UserChart from "../Components/Commons/UserChart.vue";
// End Components Reusabil

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/bills/', component: InvoiceList },
        { path: '/bills/create', component: InvoiceForm },
        { path: '/invoices/edit/:id', component: InvoiceEdit },
        { path: '/invoices/put/:id', component: InvoiceEdit },
        { path: '/invoices/show/:id', component: InvoiceShow },


        { path: '/', component: InvoiceList },
        { path: '/customers', component: CustomerList },
        { path: '/customers/create', component: CustomerForm },
        { path: '/customers/edit/:id', component: CustomerEditForm },
        { path: '/customers/put/:id', component: CustomerEditForm },
        { path: '/customers/show/:id', component: CustomerShowForm },

        { path: '/Dashboard', component: Dashboard },
       
        { path: '/user-profile', component: UserProfile },
        { path: '/home', component: Home, name: 'home' },
        { path: '/Logout', component: Logout, name: 'Logout' },
        { path: '/InvoiceChart', component: InvoiceChart, name: 'InvoiceChart' },
        { path: '/CustomerChart', component: CustomerChart, name: 'CustomerChart' },
        { path: '/UserChart', component: UserChart, name: 'UserChart' },
       
        // { path: '/portfolio', component: Portfolio },
        // { path: '/contact', component: Contact },

    ]
});

const app = createApp(MainLayout);
app.config.globalProperties.$appUrl = import.meta.env.APP_URL;
app.use(router);
app.mount('#app');