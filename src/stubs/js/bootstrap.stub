import axios from 'axios';
import Form from 'form-backend-validation';
import Vue from 'vue';

window.axios = axios;
window.Form = Form;
window.Vue = Vue;

window.axios.defaults.headers.common = {
  'X-CSRF-TOKEN': document.head
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content'),
  'X-Requested-With': 'XMLHttpRequest',
};
