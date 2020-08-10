require('./bootstrap');

window.Vue = require('vue');

Vue.component('channel-uploads', require('./components/ChannelUploads.vue').default);
Vue.component('subscribe-button', require('./components/subscribeButton.vue').default);
const app = new Vue({
    el: '#app',
});
