<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { OffenceHowProperties } from '@/pages/case-management/enviro/master/offence-how/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedOffencehow: OffenceHowProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'offencehowaddData', value: OffenceHowProperties): void
  (e: 'offencehowupdateData', value: OffenceHowProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedOffencehow: () => ({
    id: 0,
  textOnMachine: '',
  textOnLetter: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedOffencehow = ref<OffenceHowProperties>(structuredClone(toRaw(props.selectedOffencehow)))
watch(props, () => {
  selectedOffencehow.value = structuredClone(toRaw(props.selectedOffencehow))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedOffencehow.value = structuredClone(toRaw(props.selectedOffencehow))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedOffencehow.value.id>0){
        
        emit('offencehowupdateData', selectedOffencehow.value)
      }
      else{
        
        emit('offencehowaddData', {
        id:0,
        textOnMachine: selectedOffencehow.value.textOnMachine,
        textOnLetter: selectedOffencehow.value.textOnLetter,
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
    <VCard :title="(props.selectedOffencehow.textOnMachine ? 'Edit' : 'Add New') + ' Offence How' ">
      
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
              v-model="selectedOffencehow.textOnMachine"
              label="Text On Machine"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedOffencehow.textOnLetter"
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
