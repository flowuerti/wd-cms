require('./bootstrap');
require('./manage');

import Vue from 'vue';
import Buefy from 'buefy';
import changeUserPassword from './components/changeUserPassword.vue';
import imgUpload from './components/imgUpload.vue';
import collapseCardThumbnail from './components/collapseCardThumbnail';
import Tags from './components/tags';
import VeeValidate from 'vee-validate';
import EditDeleteModal from './components/editDeleteModal';

Vue.component('changeuserpassword', changeUserPassword);
Vue.component('imgupload', imgUpload);
Vue.component('collapsecardthumbnail', collapseCardThumbnail);
Vue.component('tags', Tags);
Vue.component('editdeletemodal', EditDeleteModal);

Vue.use(Buefy);
Vue.use(VeeValidate);

window.Vue = Vue;

new Vue({
    el: '#app',
    data: {
        auto_password: true,
        password_options: 'keep',

    },
    methods: {}


});