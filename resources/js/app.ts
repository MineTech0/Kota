require('./bootstrap');
require('../../node_modules/bootstrap-select/dist/js/bootstrap-select.min');

import { createPinia } from 'pinia';
import { createApp } from 'vue'
import LoanFormWrapper from './components/loan/LoanFormWrapper.vue'
import OwnLoansVue from './components/loan/OwnLoans.vue';

const pinia = createPinia()
const app = createApp({})

app.component('loan-form-wrapper', LoanFormWrapper)
app.component('own-loans', OwnLoansVue)

app.use(pinia)

app.mount('#app')
