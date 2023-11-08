<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { AddressVerifiedByProperties } from '@/pages/case-management/enviro/master/address-verified-by/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedAddressverifiedby: AddressVerifiedByProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'addressverifiedbyaddData', value: AddressVerifiedByProperties): void
  (e: 'addressverifiedbyupdateData', value: AddressVerifiedByProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedAddressverifiedby: () => ({
    id: 0,
  textOnMachine: '',
  textOnLetter: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedAddressverifiedby = ref<AddressVerifiedByProperties>(structuredClone(toRaw(props.selectedAddressverifiedby)))
watch(props, () => {
  selectedAddressverifiedby.value = structuredClone(toRaw(props.selectedAddressverifiedby))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedAddressverifiedby.value = structuredClone(toRaw(props.selectedAddressverifiedby))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedAddressverifiedby.value.id>0){
        
        emit('addressverifiedbyupdateData', selectedAddressverifiedby.value)
      }
      else{
        
        emit('addressverifiedbyaddData', {
        id:0,
        textOnMachine: selectedAddressverifiedby.value.textOnMachine,
        textOnLetter: selectedAddressverifiedby.value.textOnLetter,
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
    max-width="600"
  >
   
    <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="onSubmit"
          >
    <!-- Dialog Content -->
    <VCard :title="(props.selectedAddressverifiedby.textOnMachine ? 'Edit' : 'Add New') + ' Address Verified By' ">
      
      <DialogCloseBtn
        variant="text"
        size="small"
        @click="closeDialog"
      />

      <VCardText>
        <VRow>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedAddressverifiedby.textOnMachine"
              label="Text On Machine"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedAddressverifiedby.textOnLetter"
              label="Text On Letter"
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
