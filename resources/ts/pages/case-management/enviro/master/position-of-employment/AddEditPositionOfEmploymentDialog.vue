<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { PositionOfEmploymentProperties } from '@/pages/case-management/enviro/master/position-of-employment/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedPositionOfEmployment: PositionOfEmploymentProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'positionOfEmploymentaddData', value: PositionOfEmploymentProperties): void
  (e: 'positionOfEmploymentsupdateData', value: PositionOfEmploymentProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedPositionOfEmployment: () => ({
    id: 0,
  position_of_employment:'',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedPositionOfEmployment = ref<PositionOfEmploymentProperties>(structuredClone(toRaw(props.selectedPositionOfEmployment)))
watch(props, () => {
  selectedPositionOfEmployment.value = structuredClone(toRaw(props.selectedPositionOfEmployment))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedPositionOfEmployment.value = structuredClone(toRaw(props.selectedPositionOfEmployment))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedPositionOfEmployment.value.id>0){
        emit('PositionOfEmploymentupdateData', selectedPositionOfEmployment.value)
      }
      else{
        emit('PositionOfEmploymentaddData', {
        id:0,
        position_of_employment: selectedPositionOfEmployment.value.position_of_employment,
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
    <VCard :title="(props.selectedPositionOfEmployment.position_of_employment ? 'Edit' : 'Add New') + ' Position of Employment' ">
      
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
              v-model="selectedPositionOfEmployment.position_of_employment"
              label="Position of Employment"
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
