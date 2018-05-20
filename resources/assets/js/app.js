
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('avatar', require('./components/Avatar.vue'));
Vue.component('avatar-form', require('./components/AvatarForm.vue'));
Vue.component('like-button', require('./components/LikeButton.vue'));
Vue.component('follow-button', require('./components/FollowButton.vue'));
Vue.component('user-notifications', require('./components/UserNotifications.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('login-form', require('./components/LoginForm.vue'));
Vue.component('registration-form', require('./components/RegistrationForm.vue'));

Vue.component('post-show', require('./pages/Post.vue'));
Vue.component('wysiwyg', require('./components/Wysiwyg.vue'));

Vue.component('SweetModal', require('sweet-modal-vue/src/components/SweetModal'));
Vue.component('SweetModalTab', require('sweet-modal-vue/src/components/SweetModalTab'));

const app = new Vue({
    el: '#app'
});
