<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { ManualRepresentationReasonProperties } from '@/pages/case-management/enviro/master/manual-representation-reason/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedManualRepresentationReason: ManualRepresentationReasonProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'manualrepresentationreasonaddData', value: ManualRepresentationReasonProperties): void
  (e: 'manualrepresentationreasonupdateData', value: ManualRepresentationReasonProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedManualRepresentationReason: () => ({
    id: 0,
  reason:'',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedManualRepresentationReason = ref<ManualRepresentationReasonProperties>(structuredClone(toRaw(props.selectedManualRepresentationReason)))
watch(props, () => {
  selectedManualRepresentationReason.value = structuredClone(toRaw(props.selectedManualRepresentationReason))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedManualRepresentationReason.value = structuredClone(toRaw(props.selectedManualRepresentationReason))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedManualRepresentationReason.value.id>0){
        
        emit('manualrepresentationreasonupdateData', selectedManualRepresentationReason.value)
      }
      else{
        
        emit('manualrepresentationreasonaddData', {
        id:0,
        reason: selectedManualRepresentationReason.value.reason,
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
    <VCard :title="(props.selectedManualRepresentationReason.reason ? 'Edit' : 'Add New') + ' Manual Representation Reason' ">
      
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
              v-model="selectedManualRepresentationReason.reason"
              label="Reason"
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
