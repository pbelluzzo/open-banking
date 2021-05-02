import Vue from "vue";
import VueRouter from "vue-router";
import Home from "./views/Home";
import ClientsCreate from "./views/ClientsCreate";
import ClientsShow from "./views/ClientsShow";
import ClientsEdit from "./views/ClientsEdit";
import ClientsIndex from "./views/ClientsIndex";
import FinancialProductsIndex from "./views/FinancialProductsIndex";
import FinancialProductsCreate from "./views/FinancialProductsCreate";
import FinancialProductsShow from "./views/FinancialProductsShow";
import FinancialProductsEdit from "./views/FinancialProductsEdit";
import AccountsIndex from "./views/AccountsIndex";
import AccountsShow from "./views/AccountsShow";
import AccountsEdit from "./views/AccountsEdit";
import ContractsCreate from "./views/ContractsCreate";
import ContractsShow from "./views/ContractsShow";
import ContractsIndex from "./views/ContractsIndex";
import SharingsCreate from "./views/SharingsCreate";
import SharingsIndex from "./views/SharingsIndex";
import SharingsShow from "./views/SharingsShow";
import Logout from "./actions/Logout";

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: Home, meta: { title: 'Home'}},

        { path: '/clients', component: ClientsIndex, meta: { title: 'Clientes'}},
        { path: '/clients/create', component: ClientsCreate, meta: { title: 'Clientes'}},
        { path: '/clients/:id', component: ClientsShow, meta: { title: 'Clientes'}},
        { path: '/clients/:id/edit', component: ClientsEdit, meta: { title: 'Clientes'}},

        { path: '/financial_products', component: FinancialProductsIndex, meta: { title: 'Produtos Financeiros'}},
        { path: '/financial_products/create', component: FinancialProductsCreate, meta: { title: 'Produtos Financeiros'}},
        { path: '/financial_products/:id', component: FinancialProductsShow, meta: { title: 'Produtos Financeiros'}},
        { path: '/financial_products/:id/edit', component: FinancialProductsEdit, meta: { title: 'Produtos Financeiros'}},

        { path: '/accounts', component: AccountsIndex, meta: { title: 'Contas'}},
        { path: '/accounts/:id', component: AccountsShow, meta: { title: 'Contas'}},
        { path: '/accounts/:id/edit', component: AccountsEdit, meta: { title: 'Contas'}},

        
        { path: '/contracts', component: ContractsIndex, meta: { title: 'Contratos'}},
        { path: '/contracts/create', component: ContractsCreate, meta: { title: 'Contratos'}},
        { path: '/contracts/:id', component: ContractsShow, meta: { title: 'Contratos'}},
        
        { path: '/sharings/create', component: SharingsCreate, meta: { title: 'Compartilhamentos'}},
        { path: '/sharings', component: SharingsIndex, meta: { title: 'Compartilhamentos'}},
        { path: '/sharings/:id', component: SharingsShow, meta: { title: 'Compartilhamentos'}},
        

        { path: '/logout', component: Logout, meta: { title: 'Logout'}},
    ]
});