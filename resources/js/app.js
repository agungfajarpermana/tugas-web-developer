require('./bootstrap');
import Vue from 'vue';
import TitleHeader from './components/TitleHeader.vue';

const app = new Vue({
    el: '#app',
    components: {
        TitleHeader
    }
});
