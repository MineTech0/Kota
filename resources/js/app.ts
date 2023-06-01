require('./bootstrap');
require('../../node_modules/bootstrap-select/dist/js/bootstrap-select.min');

import { NButton } from 'naive-ui';
import { createPinia } from 'pinia';
import { createApp } from 'vue'
import CreateFileFormVue from './components/files/CreateFileForm.vue';
import FileListVue from './components/files/FileList.vue';
import LoanFormWrapper from './components/loan/LoanFormWrapper.vue'
import OwnLoansVue from './components/loan/OwnLoans.vue';
import CreateExpensesPage from './components/expenses/CreateExpensesPage.vue';
import IndexExpensesPage from './components/expenses/IndexExpensesPage.vue';
import CreateGroupForm from './components/groups/CreateGroupForm.vue';
import App from './App.vue'

const pinia = createPinia()
const app = createApp({})

app.component('loan-form-wrapper', LoanFormWrapper)
app.component('own-loans', OwnLoansVue)
app.component('file-list', FileListVue)
app.component('create-file-form', CreateFileFormVue)
app.component('create-expenses-page', CreateExpensesPage)
app.component('index-expenses-page',  IndexExpensesPage)
app.component('n-button', NButton)
app.component('create-group-form', CreateGroupForm)

app.use(pinia)

app.mount('#app')

export  {}