<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { ServiceRequestReportedViaProperties } from '@/pages/case-management/enviro/master/service-request-reported-via/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedServiceRequestReportedVia: ServiceRequestReportedViaProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'serviceRequestReportedViaaddData', value: ServiceRequestReportedViaProperties): void
  (e: 'serviceRequestReportedViaupdateData', value: ServiceRequestReportedViaProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedServiceRequestReportedVia: () => ({
    id: 0,
  reported_via:'',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedServiceRequestReportedVia = ref<ServiceRequestReportedViaProperties>(structuredClone(toRaw(props.selectedServiceRequestReportedVia)))
watch(props, () => {
  selectedServiceRequestReportedVia.value = structuredClone(toRaw(props.selectedServiceRequestReportedVia))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedServiceRequestReportedVia.value = structuredClone(toRaw(props.selectedServiceRequestReportedVia))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedServiceRequestReportedVia.value.id>0){
        emit('ServiceRequestReportedViaupdateData', selectedServiceRequestReportedVia.value)
      }
      else{
        emit('ServiceRequestReportedViaaddData', {
        id:0,
        reported_via: selectedServiceRequestReportedVia.value.reported_via,
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
    <VCard :title="(props.selectedServiceRequestReportedVia.reported_via ? 'Edit' : 'Add New') + ' Service Request Reported Via' ">
      
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
              v-model="selectedServiceRequestReportedVia.reported_via"
              label="Reported Via"
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
