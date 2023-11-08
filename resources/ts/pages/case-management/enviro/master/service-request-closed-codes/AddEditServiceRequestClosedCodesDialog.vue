<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { ServiceRequestClosedCodesProperties } from '@/pages/case-management/enviro/master/service-request-closed-codes/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedServiceRequestClosedCodes: ServiceRequestClosedCodesProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'serviceRequestClosedCodesaddData', value: ServiceRequestClosedCodesProperties): void
  (e: 'serviceRequestClosedCodesupdateData', value: ServiceRequestClosedCodesProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedServiceRequestClosedCodes: () => ({
    id: 0,
  closed_code_type:'',
  closed_code_description:'',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedServiceRequestClosedCodes = ref<ServiceRequestClosedCodesProperties>(structuredClone(toRaw(props.selectedServiceRequestClosedCodes)))
watch(props, () => {
  selectedServiceRequestClosedCodes.value = structuredClone(toRaw(props.selectedServiceRequestClosedCodes))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedServiceRequestClosedCodes.value = structuredClone(toRaw(props.selectedServiceRequestClosedCodes))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedServiceRequestClosedCodes.value.id>0){
        emit('ServiceRequestClosedCodesupdateData', selectedServiceRequestClosedCodes.value)
      }
      else{
        emit('ServiceRequestClosedCodesaddData', {
        id:0,
        closed_code_type: selectedServiceRequestClosedCodes.value.closed_code_type,
        closed_code_description: selectedServiceRequestClosedCodes.value.closed_code_description,
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
    <VCard :title="(props.selectedServiceRequestClosedCodes.closed_code_type ? 'Edit' : 'Add New') + ' Service Request Closed Codes' ">
      
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
              v-model="selectedServiceRequestClosedCodes.closed_code_type"
              label="Closed Code Type"
              :rules="[requiredValidator]"
            />
          </VCol>

          <VCol
            cols="12"
            md="12"
          >
            <VTextField
              v-model="selectedServiceRequestClosedCodes.closed_code_description"
              label="Closed Code Desc"
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
