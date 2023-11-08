<script setup lang="ts">
import { useGenerateImageVariant } from '@/@core/composable/useGenerateImageVariant'
import { useAppAbility } from '@/plugins/casl/useAppAbility'
import axios from '@axios'
import VueCountdown from '@chenfengyuan/vue-countdown'
import authV2RegisterMaskDark from '@images/pages/auth-v2-register-mask-dark.png'
import authV2RegisterMaskLight from '@images/pages/auth-v2-register-mask-light.png'
import authV2TwoStepsIllustrationBorderedDark from '@images/pages/auth-v2-two-steps-illustration-bordered-dark.png'
import authV2TwoStepsIllustrationBorderedLight from '@images/pages/auth-v2-two-steps-illustration-bordered-light.png'
import authV2TwoStepsIllustrationDark from '@images/pages/auth-v2-two-steps-illustration-dark.png'
import authV2TwoStepsIllustrationLight from '@images/pages/auth-v2-two-steps-illustration-light.png'
import { VNodeRenderer } from '@layouts/components/VNodeRenderer'
import { themeConfig } from '@themeConfig'

const authV2ThemeTwoStepMask = useGenerateImageVariant(authV2RegisterMaskLight, authV2RegisterMaskDark)
const authV2TwoStepsIllustration = useGenerateImageVariant (authV2TwoStepsIllustrationLight, authV2TwoStepsIllustrationDark, authV2TwoStepsIllustrationBorderedLight, authV2TwoStepsIllustrationBorderedDark, true)
 
const route = useRoute()
const router = useRouter()
const userEmail = localStorage.getItem('userEmail');
const timer = localStorage.getItem('timer');
const savedTimer = ref(parseInt(timer));

const ability = useAppAbility()
const otpStr = ref('');

const otp = (val: string) => {
    otpStr.value = val;
}

const errors = ref<Record<string, string | undefined>>({
  otp: undefined
})

const error = ref(false)
const isDisabled = ref(true)
const loadings = ref<boolean[]>([]);
//Validate the user otp code.
const authentiate =() =>{
    if (otpStr.value.length == 6) {
        loadings.value[0] = true;
        const hash = route.params.hash; 
        axios.post('/api/verify', { key: hash, two_factor_code: otpStr.value })
          .then(res => {
            const { accessToken, userData } = res.data.data;
            // localStorage.setItem('userAbilities', JSON.stringify(userAbilities))
            localStorage.setItem('userData', JSON.stringify(userData))
            localStorage.setItem('userAbilities', JSON.stringify(userData.abilities))
            localStorage.setItem('accessToken', JSON.stringify(accessToken))
            localStorage.removeItem('userEmail')

            ability.update(userData.abilities)

            // Redirect to `to` query if exist or redirect to index route
            router.replace(route.query.to ? String(route.query.to) : '/')
        })
        .catch(e => {
          if (e.response.status === 422) {
            error.value = e.response.data.message
          }
        })
        .finally(() => {
          loadings.value[0] = false;
        })
    }
}

const onCountdownCompleted = () =>{
  isDisabled.value = false
}

const handleCountdownProgress =(e) =>{
    const millisecond = (e.hours*60*60+e.minutes*60+e.seconds)*1000;
    localStorage.setItem('timer', millisecond);
}

//Resend the varification code.
const resentVerification =() =>{
      if (!isDisabled.value) {
        axios.get('/api/verify/resend')
          .then(res => {
            router.push('/verify/' + encodeURIComponent(res.data.data.key));
            savedTimer.value = 300000;
            isDisabled.value = true
          })
          .catch(e => {
            const { message } = e.response.data;
            errors.value = message
          })
      }
}

</script>

<template>
  
    <div class="auth-logo d-flex align-center gap-x-2"
    >
    <div>
      <VNodeRenderer :nodes="themeConfig.app.logo" />
    </div>

    <h5 class="text-h5 font-weight-bold leading-normal text-capitalize">
      {{ themeConfig.app.title }}
    </h5>
  </div>
  <VRow
    class="auth-wrapper"
    no-gutters
  >
    <VCol
      md="8"
      class="d-none d-md-flex align-center justify-center position-relative"
    >
      <!-- Here your illustrator -->
      <div class="d-flex align-center justify-center pa-10">
        <img
          :src="authV2TwoStepsIllustration"
          class="auth-illustration w-100"
          alt="auth-illustration"
        >
      </div>
      <VImg
        :src="authV2ThemeTwoStepMask"
        class="d-none d-md-flex auth-footer-mask"
        alt="auth-mask"
      />
    </VCol>

    <VCol
      cols="12"
      md="4"
      class="auth-card-v2 d-flex align-center justify-center"
      style="background-color: rgb(var(--v-theme-surface));"
    >
      <VCard
        flat
        :max-width="500"
        class="mt-12 mt-sm-0 pa-4"
      >
        <VCardText class="pt-2">
          <h5 class="text-h5 font-weight-semibold mb-1">
            Two Step Verification 💬
          </h5>
          <p class="mb-2">
            We sent a verification code to your email. Enter the code from the email in the field below.
          </p>
          <h6 class="text-base font-weight-semibold">
            {{ userEmail }}
          </h6>
        </VCardText>

        <VCardText>
          <VForm @submit.prevent="authentiate">
            <VRow>
              <VCol cols="12">
                <VAlert variant="outlined" color="error" v-if="error">
                  {{ error }}
                </VAlert>
              </VCol>
              <!-- email -->
              <VCol cols="12">
                <AppOtpInput 
                  @updateOtp="otp"
                  />
              </VCol>

              <!-- reset password -->
              <VCol cols="12">
                <VBtn
                  block
                  type="submit"
                  :loading="loadings[0]"
                  :disabled="loadings[0]"
                >
                  Verify my account
                </VBtn>
              </VCol>

              <vue-countdown v-if="isDisabled" :time="savedTimer" v-slot="{ minutes, seconds }" @end="onCountdownCompleted" @progress="(e)=>handleCountdownProgress(e)">
                <p style=" margin: 0 0 0 17px;color: red;"> Resend OTP in {{ minutes }}:{{ seconds }} seconds. </p>
              </vue-countdown>
              <!-- back to login -->
              <VCol cols="12">
                <div class="text-base d-flex justify-center align-center flex-wrap">
                  <span class="me-1">Didn't get the code?</span>
                  <a href="#" @click.prevent="resentVerification" :class="{ 'disabled': isDisabled }">Resend</a>
                </div>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>

<route lang="yaml">
meta:
  layout: blank
  action: read
  subject: Auth
</route>
