require('./bootstrap');

window.Vue = require('vue');

Vue.component('counter', require('./components/Counter.vue').default);
Vue.component('breadcrumb', require('./components/Breadcrumb.vue').default);
Vue.component('refresh-button', require('./components/RefreshButton.vue').default);
Vue.component('upload-file', require('./components/UploadFile.vue').default);
Vue.component('update-status', require('./components/UpdateStatus.vue').default);
Vue.component('tinymce', require('./components/TinyMce.vue').default);

new Vue({
    el: '#app',
});
