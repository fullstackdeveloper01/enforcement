<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { PaymentMethodProperties } from '@/pages/case-management/enviro/master/payment-method/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedPaymentmethod: PaymentMethodProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'paymentmethodaddData', value: PaymentMethodProperties): void
  (e: 'paymentmethodupdateData', value: PaymentMethodProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedPaymentmethod: () => ({
    id: 0,
  paymentMethod: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedPaymentmethod = ref<PaymentMethodProperties>(structuredClone(toRaw(props.selectedPaymentmethod)))
watch(props, () => {
  selectedPaymentmethod.value = structuredClone(toRaw(props.selectedPaymentmethod))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const paymentMethod = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedPaymentmethod.value = structuredClone(toRaw(props.selectedPaymentmethod))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedPaymentmethod.value.id>0){
        
        emit('paymentmethodupdateData', selectedPaymentmethod.value)
      }
      else{
        
        emit('paymentmethodaddData', {
        id:0,
        paymentMethod: selectedPaymentmethod.value.paymentMethod,
        status:'1'
      })
      }
      loadings.value[0] = false;
      emit('update:isDialogOpen', false) 
      nextTick(() => {
      
        refForm.value?.reset()
        refForm.value?.resetValidation()
      })
    }
  })
}

const handleDialogModelValueUpdate = (val: boolean) => {
  emit('update:isDialogOpen', val)
}
</script>

<template>
  <VDialog
  :model-value="props.isDialogOpen"
    @update:model-value="handleDialogModelValueUpdate"
    max-width="400"
  >
   
    <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="onSubmit"
          >
    <!-- Dialog Content -->
    <VCard :title="(props.selectedPaymentmethod.paymentMethod ? 'Edit' : 'Add New') + ' Payment Method' ">
      
      <DialogCloseBtn
        variant="text"
        size="small"
        @click="closeDialog"
      />

      <VCardText>
        <VRow>
          <VCol
            cols="12"
            md="12"
          >
            <VTextField
              v-model="selectedPaymentmethod.paymentMethod"
              label="Payment Method"
              :rules="[requiredValidator]"
            />
          </VCol>
          
         
        </VRow>
      </VCardText>

      <VCardActions>
        <VSpacer />
        <VBtn
        
          color="error"
          @click="closeDialog"
        >
          Close
        </VBtn>
        <VBtn
        :loading="loadings[0]"
        :disabled="loadings[0]"
         type="submit"
        color="success"
        
        >
          Save
        </VBtn>
      </VCardActions>
    </VCard>
  </VForm>
  </VDialog>
  
</template>
