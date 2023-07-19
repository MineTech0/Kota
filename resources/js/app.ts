require('./bootstrap');

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
import EditGroupForm from './components/groups/EditGroupForm.vue';
import UserGroupsTable from './components/groups/UserGroupsTable.vue';
import UsersTable from './components/users/UsersTable.vue';
import Message from './components/Message.vue';
import EquipmentTable from './components/equipment/EquipmentTable.vue';
import RolesPermissionsTable from './components/users/RolesPermissionsTable.vue';
import CreateInviteForm from './components/invites/CreateInviteForm.vue';
import InvitesTable from './components/invites/InvitesTable.vue';
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
app.component('edit-group-form', EditGroupForm)
app.component('user-group-table',UserGroupsTable )
app.component('users-table', UsersTable)
app.component('equipment-table', EquipmentTable)
app.component('message', Message)
app.component('roles-permissions-table', RolesPermissionsTable)
app.component('create-invite-form',CreateInviteForm)
app.component('invites-table', InvitesTable)
app.component('app', App)

app.use(pinia)

app.mount('#app')

export  {}