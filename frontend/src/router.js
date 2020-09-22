import Vue from 'vue';
import VueRouter from 'vue-router';
import userIndex from './components/pages/passport/userIndex';
import orgInfo from './components/pages/passport/orgInfo';
import areaInfo from './components/pages/passport/areaInfo';
import livingInfo from './components/pages/passport/livingInfo';
import livingInfoInv from './components/pages/passport/livingInfoInv';
import object from './components/pages/object/object';
import objectArea from './components/pages/object/objectArea';
import objectTariff from './components/pages/object/objectTariff';
import objectMoney from './components/pages/object/objectMoney';
import uploadPage from './components/pages/docs/uploadPage';
import manual from './components/pages/passport/manual';

Vue.use(VueRouter);

const routes = [
  {
    path: '/main',
    component: userIndex,
  },
  {
    path: '/org-info',
    component: orgInfo,
  },
  {
    path: '/area-info',
    component: areaInfo,
  },
  {
    path: '/living-info',
    component: livingInfo,
  },
  {
    path: '/living-info-inv',
    component: livingInfoInv,
  },
  {
    path: '/objects-info',
    component: object,
    name: 'object',
    props: true,

  },
  {
    path: '/objects-area',
    component: objectArea,
  },
  {
    path: '/objects-tariff',
    component: objectTariff,
  },
  {
    path: '/objects-money',
    component: objectMoney,
  },
  {
    path: '/documents',
    component: uploadPage,
  },
  {
    path: '/manual',
    component: manual,
  },

];

export default new VueRouter({
  mode: 'history',
  routes,
});
