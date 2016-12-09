import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'

Vue.use(VueRouter);

Vue.use(VueResource)

/* eslint-disable no-new */

var router = new VueRouter({
    history: true,
    root: '/'
})

router.map({
	'/': {
        component: require('./components/Home.vue')
    },
    '': {
        component: require('./components/Home.vue')
    },
    '/auth/login': {
        component: require('./components/Auth/Login.vue')
    },
    '/goods/list': {
        component: require('./components/Goods/GoodsList.vue')
    },
    '/goods/add': {
        component: require('./components/Goods/GoodsAdd.vue')
    },
    '/goods/edit/:id': {
        name: 'goods_edit',
        component: require('./components/Goods/GoodsAdd.vue')
    },
    '/goods_mfrs/add/:goods_id': {
        name: 'goods_mfrs_add',
        component: require('./components/Goods/GoodsMfrs.vue')
    },
    '/goods_mfrs/edit/:id':{
        name: 'goods_mfrs_edit',
        component: require('./components/Goods/GoodsMfrs.vue')
    },
    '/supplier/list': {
        component: require('./components/Supplier/SupplierList.vue')
    },
    '/supplier/add': {
        component: require('./components/Supplier/SupplierAdd.vue')
    },
    '/supplier/edit/:id': {
        name: 'supplier_edit',
        component: require('./components/Supplier/SupplierAdd.vue')
    },
    '/goods_supplier/add/:goods_id': {
        name: 'goods_supplier_add',
        component: require('./components/Goods/GoodsSupplier.vue')
    },
})

router.beforeEach(function (transition) {
    if (transition.to.path === '/auth/login') {
        if(_global.user == ''){
            transition.next();
        }else{
            //transition.redirect('/')
            window.location.href='/'
        }
    }else{
        transition.next();
    }
})
router.start(App, 'body')