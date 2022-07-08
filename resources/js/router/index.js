import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Root from '../components/info/container'
import Dashboard from '../components/dashboard/container'
import Info from '../components/info/container'
import ProfileShow from '../components/profile-show/container'
import Order from '../components/safir/allShops'
import Sell from '../components/sell/container'
import SendBack from '../components/safir/safirSendBack'
import notRegistered from '../components/errors/notRegistered'
import EditProfile from '../components/profile/container'
import SafirSendOrder from '../components/safir/sendOrder'
import SafirShowOrders from '../components/safir/safirAllOrders'
import safirShopOrderShow from '../components/safir/orderShow'
import safirInvoiceShow from '../components/safir/invoiceShow'
import safirInventory from '../components/safir/safirInventory'
import safirInvoice from '../components/safir/invoice'

//Admin Components
import adminDashboard from '../components/admin/dashboard/dashboardComponent'
import newResumesList from '../components/admin/safir/newResumes'
import allResumesList from '../components/admin/safir/allResumes'
import resumeShow from '../components/admin/safir/resumeShow'
import resumeReconsider from '../components/admin/safir/resumeReconsider'
import newShopResumesList from '../components/admin/shop/newShopResumes'
import allShopResumesList from '../components/admin/shop/allShopResumes'
import shopResumeShow from '../components/admin/shop/shopResumeShow'
import shopResumeReconsider from '../components/admin/shop/shopResumeReconsider'
import Books from '../components/admin/books/booksComponent'
import allTransitions from '../components/admin/allTransitions/allTransitions'
import adminSafirShopOrderShow from '../components/admin/allTransitions/safirShopOrderShow'
import distOrderShow from '../components/admin/distributor/orderShow'
import adminCustomerOrderShow from '../components/admin/allTransitions/invoiceShow'
import newDistResumesList from '../components/admin/distributor/newDistResumes'
import distResumeShow from '../components/admin/distributor/distResumeShow'
import settings from '../components/admin/general/settings'
import adminStats from '../components/admin/stats/stats'
import adminShopStats from '../components/admin/shop/shopStats'

//Shop Components
import allDists from '../components/shop/allDists'
import shopDashboard from '../components/shop/shopDashboard'
import shopAllOrders from '../components/shop/shopAllOrders'
import shopOrderShow from '../components/shop/orderShow'
import safirOrderShow from '../components/shop/safirOrderShow'
import shopCustomerOrderShow from '../components/shop/invoiceShow'
import shopInventory from '../components/shop/shopInventory'
import editShopProfile from '../components/shop/shopProfile'
import shopProfileShow from '../components/shop/shopProfileShow'
import shopTarhBooks from '../components/shop/books'
import distShow from '../components/shop/sendOrder'
import shopSendInvoice from '../components/shop/invoice'
import shopSellStats from "../components/shop/stats/shopSellStats";
import shopFiles from "../components/shop/tarhFiles/files";


//Distributor Components
import distBooks from '../components/distributor/books/books'
import editDistributorProfile from '../components/distributor/profile/distributorProfile'
import distributorProfileShow from '../components/distributor/profile/distributorProfileShow'
import allShops from '../components/distributor/shops/allShops'
import allOrders from '../components/distributor/orders/allOrders'
import orderShow from '../components/distributor/orders/orderShow'
import shopStats from "../components/admin/shop/shopStats";

const routes = [
    {
        component: Dashboard,
        name: 'Dashboard',
        path: '/',
        redirect: '/dashboard',
        children: [{
            path: '/dashboard',
            name: 'Root',
            component: Root
        }]
    },
    {
        component: Info,
        name: 'info',
        path: '/info',
    },
    {
        component: ProfileShow,
        name: 'profile-show',
        path: '/profileShow',
    },
    {
        component: Order,
        name: 'Order',
        path: '/order',
    },
    {
        component: SafirSendOrder,
        name: 'SafirSendOrder',
        path: '/shopShow/:id',
    },
    {
        component: safirInvoice,
        name: 'safirInvoice',
        path: '/sell',
    },
    {
        component: safirShopOrderShow,
        name: 'safirShopOrderShow',
        path: '/safirShopOrderShow/:id',
    },
    {
        component: safirInvoiceShow,
        name: 'safirInvoiceShow',
        path: '/customerOrderShow/:id',
    },
    {
        component: SafirShowOrders,
        name: 'SafirShowOrders',
        path: '/safirShowOrders',
    },
    {
        component: safirInventory,
        name: 'safirInventory',
        path: '/safirInventory',
    },
    {
        component: SendBack,
        name: 'sendBack',
        path: '/sendBack',
    },
    {
        component: Sell,
        name: 'sell',
        path: '/sell',
    },
    {
        component: notRegistered,
        name: 'notRegistered',
        path: '/err',
    },
    {
        component: EditProfile,
        name: 'editProfile',
        path: '/editProfile',
    },
    {
        component: adminDashboard,
        name: 'adminDashboard',
        path: '/adminDashboard',
    },
    {
        component: settings,
        name: 'settings',
        path: '/settings',
    },
    {
        component: adminStats,
        name: 'adminStats',
        path: '/adminStats',
    },
    {
        component: newResumesList,
        name: 'newResumesList',
        path: '/newResumes',
    },
    {
        component: resumeShow,
        name: 'resumeShow',
        path: '/newResumes/:id',
    },
    {
        component: allResumesList,
        name: 'allResumesList',
        path: '/allResumes',
    },
    {
        component: resumeReconsider,
        name: 'resumeReconsider',
        path: '/allResumes/:id',
    },


    {
        component: newShopResumesList,
        name: 'newShopResumesList',
        path: '/newShopResumes',
    },
    {
        component: shopResumeShow,
        name: 'shopResumeShow',
        path: '/newShopResumes/:id',
    },
    {
        component: allShopResumesList,
        name: 'allShopResumesList',
        path: '/allShopResumes',
    },
    {
        component: shopResumeReconsider,
        name: 'shopResumeReconsider',
        path: '/allShopResumes/:id',
    },
    {
        component: Books,
        name: 'Books',
        path: '/books',
    },
    {
        component: allTransitions,
        name: 'allTransitions',
        path: '/allTransitions',
    },
    {
        component: distOrderShow,
        name: 'distOrderShow',
        path: '/distOrderShow/:id',
    },
    {
        component: adminSafirShopOrderShow,
        name: 'adminSafirShopOrderShow',
        path: '/adminSafirShopOrderShow/:id',
    },
    {
        component: adminCustomerOrderShow,
        name: 'adminCustomerOrderShow',
        path: '/adminCustomerOrderShow/:id',
    },
    {
        component: adminShopStats,
        name: 'adminShopStats',
        path: '/adminShopStats/:id',
    },
    //------------------------------------------------------------------------
    //--------------------------------Shop------------------------------------
    //------------------------------------------------------------------------
    {
        component: shopDashboard,
        name: 'shopDashboard',
        path: '/shopDashboard',
    },

    {
        component: shopAllOrders,
        name: 'shopAllOrders',
        path: '/shopAllOrders',
    },
    {
        component: shopOrderShow,
        name: 'shopOrderShow',
        path: '/shopOrderShow/:id',
    },
    {
        component: safirOrderShow,
        name: 'safirOrderShow',
        path: '/safirOrderShow/:id',
    },
    {
        component: shopCustomerOrderShow,
        name: 'shopCustomerOrderShow',
        path: '/shopCustomerOrderShow/:id',
    },
    {
        component: shopInventory,
        name: 'shopInventory',
        path: '/shopInventory',
    },
    {
        component: shopTarhBooks,
        name: 'shopBooks',
        path: '/shopBooks',
    },
    {
        component: editShopProfile,
        name: 'editShopProfile',
        path: '/editShopProfile',
    },
    {
        component: shopProfileShow,
        name: 'shopProfileShow',
        path: '/shopProfileShow',
    },
    {
        component: distShow,
        name: 'distShow',
        path: '/distShow/:id',
    },
    {
        component: shopSendInvoice,
        name: 'shopSendInvoice',
        path: '/shopDirectSell',
    },
    {
        component: allDists,
        name: 'allDists',
        path: '/allDists',
    },
    {
        component: shopSellStats,
        name: 'shopSellStats',
        path: '/shopSellStatistics',
    },
    {
        component: shopFiles,
        name: 'shopFiles',
        path: '/files',
    },

    //------------------------------------------------------------------------
    //----------------------------Distributor---------------------------------
    //------------------------------------------------------------------------
    {
        component: distBooks,
        name: 'distBooks',
        path: '/distributorBooks',
    },
    {
        component: allShops,
        name: 'allShops',
        path: '/allShops',
    },
    {
        component: allOrders,
        name: 'allOrders',
        path: '/allDistributorOrders',
    },
    {
        component: orderShow,
        name: 'orderShow',
        path: '/orderShow/:id',
    },
    {
        component: editDistributorProfile,
        name: 'editDistributorProfile',
        path: '/editDistributorProfile',
    },
    {
        component: distributorProfileShow,
        name: 'distProfileShow',
        path: '/distProfileShow',
    },
    {
        component: newDistResumesList,
        name: 'newDistResumesList',
        path: '/newDistResumes',
    },
    {
        component: distResumeShow,
        name: 'distResumeShow',
        path: '/newDistResumes/:id',
    },
];
export default new VueRouter({
    routes: routes
});
