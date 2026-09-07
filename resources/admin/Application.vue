<template>
    <div class="atcfe-wrapper">
        <h1 class="heading-title">
          Advanced Testimonial Carousel Settings
        </h1>
        <div class="atcfe-tabs">
            <div class="atcfe-tab-nav">
                <el-radio-group v-model="settingTabMenu" @change="settingTabChangeHandler" style="margin-bottom: 30px;">
                    <el-radio-button class="atcfe-tab-btn" label="settings">
                      <i class="el-icon-setting"></i>
                      Settings
                    </el-radio-button>
                    <el-radio-button class="atcfe-tab-btn" label="recommended_addons">
                      <i class="el-icon-circle-plus-outline"></i>
                      Recommended Addons
                    </el-radio-button>
                    <el-radio-button class="atcfe-tab-btn" label="license_settings" v-if="hasPro">
                      <i class="el-icon-lock"></i>
                      License Settings
                    </el-radio-button>
                </el-radio-group>
            </div>

            <div class="atcfe-tab-content">
              <div class="atcfe-tab-pane active" v-if="settingTabMenu === 'settings'">
                    <Settings/>
                </div>
                <div class="atcfe-tab-pane active" v-if="settingTabMenu === 'recommended_addons'">
                      <RecommendedAddonsRender/>
                </div>
                <div class="atcfe-tab-pane active" v-if="settingTabMenu === 'license_settings' && hasPro">
                   <LicenseManagement/>
                </div>
            </div>
        </div>  
    </div>
</template>

<script>
import RecommendedAddonsRender from "./Modules/RecommendedAddons";
import Settings from "./Modules/Settings";
import LicenseManagement from "./Modules/LicenseManagement";

export default {
  name: 'application',
  components: {
    RecommendedAddonsRender,
    Settings,
    LicenseManagement
  },
  data() {
    return {
      fetching: false,
      saving: false,
      settingTabMenu: localStorage.getItem('atcfe_active_menu_settings') || 'settings',
      hasPro: false,
    };
  },
  methods: {
    settingTabChangeHandler(val) {
      localStorage.setItem('atcfe_active_menu_settings', val)
    },

    hasProMethod() {
      setTimeout(() => {
        this.hasPro = !!window.atcAdminVars?.has_pro;
      }, 500);
    },
    // getSettings(){
    //   this.fetching = true;
    //   this.$post({
    //     action: "atcfe_global_settings_admin_ajax",
    //     route: "get_settings",
    //     nonce: window.atcfeAdminVars.nonce,
    //   })
    //       .then((response) => {
    //         this.settings = response.data.settings;
    //       })
    //       .fail((error) => {
    //         this.$handleError(error);
    //       })
    //       .always(() => {
    //         setTimeout(() => {
    //           this.fetching = false;
    //         }, 1000);
    //       });
    // },
    // saveSettings() {
    //   this.saving = true;
    //   this.$post({
    //     action: "atcfe_global_settings_admin_ajax",
    //     route: "save_settings",
    //     settings: this.settings,
    //     nonce: window.atcfeAdminVars.nonce,
    //   })
    //       .then((response) => {
    //         this.getSettings();
    //         // setTimeout(() => {
    //         //   // this.fetching = true;
    //         //   // location.reload();
    //         // }, 1000);
    //         this.$handleSuccess(response.data.message);
    //       })
    //       .fail((error) => {
    //         this.$handleError(error);
    //       })
    //       .always(() => {
    //         this.saving = false;
    //       });
    // },
  },
  mounted() {
    this.hasProMethod();
  }
}
</script>