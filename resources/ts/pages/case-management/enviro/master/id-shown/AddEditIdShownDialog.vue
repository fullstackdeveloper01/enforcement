<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { IdShownProperties } from '@/pages/case-management/enviro/master/id-shown/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedIdshown: IdShownProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'idshownaddData', value: IdShownProperties): void
  (e: 'idshownupdateData', value: IdShownProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedIdshown: () => ({
    id: 0,
  textOnMachine: '',
  textOnLetter: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedIdshown = ref<IdShownProperties>(structuredClone(toRaw(props.selectedIdshown)))
watch(props, () => {
  selectedIdshown.value = structuredClone(toRaw(props.selectedIdshown))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedIdshown.value = structuredClone(toRaw(props.selectedIdshown))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedIdshown.value.id>0){
        
        emit('idshownupdateData', selectedIdshown.value)
      }
      else{
        
        emit('idshownaddData', {
        id:0,
        textOnMachine: selectedIdshown.value.textOnMachine,
        textOnLetter: selectedIdshown.value.textOnLetter,
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
    <VCard :title="(props.selectedIdshown.textOnMachine ? 'Edit' : 'Add New') + ' Id Shown' ">
      
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
              v-model="selectedIdshown.textOnMachine"
              label="Text On Machine"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedIdshown.textOnLetter"
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
