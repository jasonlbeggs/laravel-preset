import './bootstrap';
import PortalVue from 'portal-vue';

Vue.use(PortalVue);

Vue.mixin({
  computed: {
    $user: () => window.User,
  },
});

new Vue({
  data: {
    displayNavigation: false,
  },
  methods: {
    logout() {
      this.$refs.logoutForm.submit();
    },
  },
}).$mount('#app');
