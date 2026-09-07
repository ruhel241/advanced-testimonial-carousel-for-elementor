<template>
    <div class="atcfe-addons-wrapper">
        <div class="atcfe-addons-heading">
            <h1> Elementor Recommended Addons </h1>
            <p>	These are the Elementor addons that will help your business. </p>  
        </div>

        <div id="atcfe-loading-addon" v-if="fetching">
            <img :src="imageUrl()+'loading.gif'" alt="">
            <h2> Loading..... </h2>
        </div>

        <div class="atcfe-addons-wrap" v-else>
            <div class="atcfe-addons-templates" v-for="addon in getRecommendedAddons" :key="addon.id">
                <div class="addons-box">
                    <div class="image">
                        <img :src="addon.logo" alt="">
                    </div>
                    <h2>{{ addon.title }}</h2>
                    <p>{{ addon.description }}</p>
                    <div class="btn-box">
                        <a class="btn atcfe-install-addon" @click="saveAddons(addon.route)" v-if="!addon.is_installed">
                           {{ addon.action_text }}
                        </a>
                        <a :href="addon.settings_url" class="viewInstall" target="_blank" v-else>
                            View Settings
                        </a>
                        <a :href="addon.upgrade_to_pro_link" class="upgrade-to-pro" target="_blank">
                            Upgrade to Pro
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
  name: 'recommended-addons',

  data() {
    return {
      fetching: false,
      getRecommendedAddons: [],
      saving: false,
      hasPro: false,
     //   settingTabMenu: localStorage.getItem('atcfe_active_menu_settings') || 'settings',
    };
  },
  methods: {
    imageUrl() {
      return window.atcAdminVars.assets_url+'images/';
    },
    // settingTabChangeHandler(val) {
    //   localStorage.setItem('atcfe_active_menu_settings', val)
    // },
   
    getAddons(){
      this.fetching = true;
      this.$get({
        action: "atc_settings_admin_ajax",
        route: "get_addons",
        nonce: window.atcAdminVars.nonce,
      })
          .then((response) => {
            setTimeout(() => {
               this.fetching = false;
               this.getRecommendedAddons = response.data.get_addons;
            }, 1000);
          })
          .fail((error) => {
            this.$handleError(error);
          })
          .always(() => {
            setTimeout(() => {
              this.fetching = false;
            }, 1000);
          });
    },
    saveAddons(route) {
      this.fetching = true;
      this.$post({
        action: "atc_settings_admin_ajax",
        route: route,
        nonce: window.atcAdminVars.nonce,
      })
          .then((response) => {
            this.getAddons();
            this.$handleSuccess(response.data.message);
          })
          .fail((error) => {
            this.$handleError(error);
          })
          .always(() => {
            this.fetching = false;
          });
    },
  },
  mounted() {
    setTimeout(() => {
       this.getAddons();
    }, 0);
    
    // jQuery('head title').text('Settings - Swift Certificate Manager');
  }
}
</script>