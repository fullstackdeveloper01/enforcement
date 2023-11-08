<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { EthnicityProperties } from '@/pages/case-management/enviro/master/ethnicity/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedEthnicity: EthnicityProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'ethnicityaddData', value: EthnicityProperties): void
  (e: 'ethnicityupdateData', value: EthnicityProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedEthnicity: () => ({
    id: 0,
  textOnMachine: '',
  textOnLetter: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedEthnicity = ref<EthnicityProperties>(structuredClone(toRaw(props.selectedEthnicity)))
watch(props, () => {
  selectedEthnicity.value = structuredClone(toRaw(props.selectedEthnicity))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedEthnicity.value = structuredClone(toRaw(props.selectedEthnicity))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedEthnicity.value.id>0){
        
        emit('ethnicityupdateData', selectedEthnicity.value)
      }
      else{
        
        emit('ethnicityaddData', {
        id:0,
        textOnMachine: selectedEthnicity.value.textOnMachine,
        textOnLetter: selectedEthnicity.value.textOnLetter,
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
    <VCard :title="(props.selectedEthnicity.textOnMachine ? 'Edit' : 'Add New') + ' Ethnicity' ">
      
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
              v-model="selectedEthnicity.textOnMachine"
              label="Text On Machine"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedEthnicity.textOnLetter"
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
