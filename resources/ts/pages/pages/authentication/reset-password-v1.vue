<script setup lang="ts">
import { VNodeRenderer } from '@layouts/components/VNodeRenderer';
import { themeConfig } from '@themeConfig';
import axios from 'axios';

// const authV1ResetPasswordMask = useGenerateImageVariant(authV1ResetPasswordMaskLight, authV1ResetPasswordMaskDark)

const route = useRoute()
const router = useRouter()

const errors = ref<Record<string, string | undefined>>({
  password: undefined,
})

const newPassword = ref('')
const confirmPassword = ref('')
const isPasswordVisible = ref(false)
const isConfirmPasswordVisible = ref(false)
const loadings = ref<boolean[]>([]);
const password = ref<Record<string, string | undefined>>({
  reset: undefined
})

const onSubmit = () => {
  loadings.value[0] = true;
  const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;
  
  if (newPassword.value !== confirmPassword.value) {
    errors.value.password = 'Passwords does not match';
    loadings.value[0] = false;
    return
  }

  if (!passwordRegex.test(newPassword.value)) {
    errors.value.password = 'Password must contain at least 8 characters, including at least one uppercase letter, one lowercase letter, and one number'
    loadings.value[0] = false;
    return
  }
  
  axios.post('/api/password/reset', { email: route.query.email, password: newPassword.value, password_confirmation: confirmPassword.value, token: route.params.hash })
    .then(res => {
      password.value.reset = res.data.message;     
      router.push('/');
    })
    .catch(e => {
      console.log(e);
    })
    .finally(() => {
      loadings.value[0] = false;
    })
}

</script>

<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard
      class="auth-card pa-2 pt-7"
      max-width="448"
    >
      <VCardItem class="justify-center">
        <template #prepend>
          <div class="me-n2">
            <VNodeRenderer :nodes="themeConfig.app.logo" />
          </div>
        </template>

        <VCardTitle class="font-weight-bold text-2xl">
          {{ themeConfig.app.title }}
        </VCardTitle>
      </VCardItem>

      <VCardText class="pt-2">
        <h5 class="text-h5 font-weight-semibold mb-1">
          Reset Password 🔒
        </h5>
        <p class="mb-0">
          Enter your email and we'll send you instructions to reset your password
        </p>
      </VCardText>

      <VCardText>
        <VForm @submit.prevent="onSubmit">
          <VRow>
            <VCol cols="12">
                <div>
                  <VAlert variant="outlined" color="error" v-if="errors.password">
                    {{ errors.password }}
                  </VAlert>
                  <VAlert variant="outlined" color="success" v-if="password.reset">
                    {{ password.reset }}
                  </VAlert>
              </div>
              </VCol>
            <!-- password -->
            <VCol cols="12">
              <VTextField
                v-model="newPassword"
                label="New Password"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
              />
            </VCol>

            <!-- Confirm Password -->
            <VCol cols="12">
              <VTextField
                v-model="confirmPassword"
                label="Confirm Password"
                :type="isConfirmPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isConfirmPasswordVisible ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                @click:append-inner="isConfirmPasswordVisible = !isConfirmPasswordVisible"
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
                Set New Password
              </VBtn>
            </VCol>

            <!-- back to login -->
            <VCol cols="12">
              <RouterLink
                class="d-flex align-center justify-center"
                :to="{ name: 'login' }"
              >
                <VIcon
                  start
                  size="30"
                  icon="mdi-chevron-left"
                  class="flip-in-rtl"
                />
                <span class="text-base">Back to login</span>
              </RouterLink>
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
    <VImg
      :src="authV1ResetPasswordMask"
      class="d-none d-md-block auth-footer-mask"
    />
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>

<route lang="yaml">
meta:
  layout: blank
</route>
