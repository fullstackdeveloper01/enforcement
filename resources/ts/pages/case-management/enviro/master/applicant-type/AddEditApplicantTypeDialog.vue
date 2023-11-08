<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { ApplicantTypeProperties } from '@/pages/case-management/enviro/master/applicant-type/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedApplicantType: ApplicantTypeProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'applicanttypeaddData', value: ApplicantTypeProperties): void
  (e: 'applicanttypeupdateData', value: ApplicantTypeProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedApplicantType: () => ({
    id: 0,
    applicant_type:'',
    status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedApplicantType = ref<ApplicantTypeProperties>(structuredClone(toRaw(props.selectedApplicantType)))
watch(props, () => {
  selectedApplicantType.value = structuredClone(toRaw(props.selectedApplicantType))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedApplicantType.value = structuredClone(toRaw(props.selectedApplicantType))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedApplicantType.value.id>0){
        
        emit('applicanttypeupdateData', selectedApplicantType.value)
      }
      else{
        emit('applicanttypeaddData', {
        id:0,
        applicant_type: selectedApplicantType.value.applicant_type,
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
    <VCard :title="(props.selectedApplicantType.applicant_type ? 'Edit' : 'Add New') + 'Applicant Type' ">
      
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
              v-model="selectedApplicantType.applicant_type"
              label="Applicant Type"
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
