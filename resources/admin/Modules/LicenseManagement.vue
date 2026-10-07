<template>
    <div class="atc_license_box">
        <div 
            class="notice notice-error" 
            id="atc-notice-error" 
            v-if="showError"
            @click="hideError" 
            style="cursor: pointer; margin-bottom: 30px;">
            <p>{{errorMessage}}</p>
        </div>
        
        <div id="atc-loading-addon" v-if="fetching">
            <img :src="imageUrl()+'loading.gif'" alt="">
            <h2> Loading..... </h2>
        </div>

        <div class="atc_license_box_content" v-else>
            <div id="atc_activated_license" v-if="licenseStatus != 'valid'">
                <h3 class="title">Please Provide a license key of Advanced Testimonial Carousel Pro Addon</h3> 
                <div class="atc-input atc-input-group atc-input-group--append">
                    <input type="text" id="atc_license_settings_field" placeholder="License Key" class="atc_input__inner" v-model="licenseKey">
                    <div class="atc-input-group__append">
                        <a href="#" @click="verifyLicense" id="atc_verify_btn" class="atc-button atc-button--success">
                            &#128274; Verify License
                        </a>
                    </div>
                </div> 
                <hr style="margin: 20px 0px 30px;"> 
                <p>Don't have a license key? <a href="https://wpcreativeidea.com/" target="_blank" style="cursor:pointer">Purchase one here</a></p>
            </div>

            <div id="atc_deactivated_license" v-if="licenseStatus === 'valid'">
                <div class="text-align-center">
                    <span style="font-size: 50px;" class="el-icon el-icon-circle-check"></span>
                </div>
                <h2>You license key is valid and activated</h2>
                <hr style="margin: 20px 0px;" />
                <p>Want to deactivate this license? <a id="atc_deactive_license" href="#" @click="deactiveLicense">Click here</a></p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
  name: 'license-management',
  data() {
    return {
      fetching: false,
      saving: false,
      licenseStatus: '',
      licenseKey: '',
      hasPro: !!window.atcAdminVars?.has_pro,
      errorMessage: 'Something is wrong!',
      showError: false
    };
  },
  methods: {
    hideError() {
        this.showError = false;
    },

    showErrorMessage(message) {
        this.errorMessage = message || 'Something is wrong!';
        this.showError = true;
    },

    imageUrl() {
      return window.atcAdminVars.assets_url+'images/';
    },
  
    getStatusLicense() {
      this.fetching = true;
      this.$get({
        action: "atc_pro_license_ajax_actions",
        route: "get_license_status",
        nonce: window.atcAdminVars.nonce,
      })
          .then((response) => {
            setTimeout(() => {
               this.fetching = false;
               this.licenseStatus = response.data.license_data.status;
            }, 500);
          })
          .fail((error) => {
             console.log('Something is wrong! Please try again');
            this.$handleError(error);
          })
          .always(() => {
            setTimeout(() => {
              this.fetching = false;
            }, 500);
          });
    },

    verifyLicense() {
        this.saving = true;
        this.fetching = true;
        this.$post({
            action: "atc_pro_license_ajax_actions",
            route: "activate_license",
            license_key: this.licenseKey,
            nonce: window.atcAdminVars.nonce,
        })
            .then((response) => {
                setTimeout(() => {
                    if (response.success == true) {
                        this.getStatusLicense();
                    } else {
                        this.showErrorMessage(response.data.message);
                        this.fetching = false;
                    }
                }, 500);
            })
            .fail((error) => {
                console.log('Something is wrong! Please try again');
                this.$handleError(error);
            })
            .always(() => {
                this.saving = false;
            });
    },

    deactiveLicense() {
        this.fetching = true;
        this.$post({
            action: "atc_pro_license_ajax_actions",
            route: "deactivated_license",
            nonce: window.atcAdminVars.nonce,
        })
            .then((response) => {
                this.getStatusLicense();
            })
            .fail((error) => {
                console.log('Something is wrong! Please try again');
                this.$handleError(error);
            })
            .always(() => {
            });
    },
  },
  mounted() {
    if (this.hasPro) {
        this.getStatusLicense();
    }
  }
}
</script>