import axios from 'axios';
import router from './../router/index';

import qs from 'qs';

axios.defaults.baseURL = '/api/';
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

export function post(url, data = []) {
  return send(url, data, 'post');
}

export function patch(url, data = []) {
  return send(url, data, 'patch');
}

export function deleteRecord(url, data = []) {
  return send(url, data, 'delete');
}

export function get(url, data = {}) {
  return axios({
    url: url + '?' + qs.stringify(data),
    method: 'GET',
  }).catch(error => {
    if (error.response.status === 403) {
      router.go(-1);
    } else if (error.response.status === 401) {
      window.location.reload();
    }
    throw error;
  });
}

export function send(url, data = [], method) {
  return axios({
    url: url,
    method: method,
    data: data
  });
}
