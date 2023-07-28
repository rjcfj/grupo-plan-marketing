import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', name: 'home', component: () => import('pages/IndexPage.vue') }],
  },
  {
    path: '/marca',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', name: 'marca', component: () => import('pages/Marca/IndexPage.vue') },
      { path: 'form-marca/:id?', name: 'formMarca', component: () => import('pages/Marca/Form.vue') },
      { path: 'form-filter', name: 'filterMarca', component: () => import('pages/Marca/FilterRow.vue') }],
  },
  {
    path: '/eletrodomesticos',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', name: 'eletrodomestico', component: () => import('pages/Eletrodomestico/IndexPage.vue') },
      { path: 'form-eletrodomestico/:id?', name: 'formEletrodomestico', component: () => import('pages/Eletrodomestico/Form.vue') },
      { path: 'form-filter', name: 'filterEletrodomestico', component: () => import('pages/Eletrodomestico/FilterRow.vue') }],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
