<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { RepresentationAcceptReasonProperties } from '@/pages/case-management/enviro/master/representation-accept-reason/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedRepresentationAcceptReason: RepresentationAcceptReasonProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'representationacceptreasonaddData', value: RepresentationAcceptReasonProperties): void
  (e: 'representationacceptreasonupdateData', value: RepresentationAcceptReasonProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedRepresentationAcceptReason: () => ({
    id: 0,
  reason:'',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedRepresentationAcceptReason = ref<RepresentationAcceptReasonProperties>(structuredClone(toRaw(props.selectedRepresentationAcceptReason)))
watch(props, () => {
  selectedRepresentationAcceptReason.value = structuredClone(toRaw(props.selectedRepresentationAcceptReason))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedRepresentationAcceptReason.value = structuredClone(toRaw(props.selectedRepresentationAcceptReason))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedRepresentationAcceptReason.value.id>0){
        
        emit('representationacceptreasonupdateData', selectedRepresentationAcceptReason.value)
      }
      else{
        emit('representationacceptreasonaddData', {
        id:0,
        reason: selectedRepresentationAcceptReason.value.reason,
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
    <VCard :title="(props.selectedRepresentationAcceptReason.reason ? 'Edit' : 'Add New') + 'Representation Accept Reason' ">
      
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
              v-model="selectedRepresentationAcceptReason.reason"
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
