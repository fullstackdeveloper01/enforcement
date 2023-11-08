<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { OffenderHairColourProperties } from '@/pages/case-management/enviro/master/offender-hair-colour/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedOffenderhaircolour: OffenderHairColourProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'offenderhaircolouraddData', value: OffenderHairColourProperties): void
  (e: 'offenderhaircolourupdateData', value: OffenderHairColourProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedOffenderhaircolour: () => ({
    id: 0,
  textOnMachine: '',
  textOnLetter: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedOffenderhaircolour = ref<OffenderHairColourProperties>(structuredClone(toRaw(props.selectedOffenderhaircolour)))
watch(props, () => {
  selectedOffenderhaircolour.value = structuredClone(toRaw(props.selectedOffenderhaircolour))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedOffenderhaircolour.value = structuredClone(toRaw(props.selectedOffenderhaircolour))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedOffenderhaircolour.value.id>0){
        
        emit('offenderhaircolourupdateData', selectedOffenderhaircolour.value)
      }
      else{
        
        emit('offenderhaircolouraddData', {
        id:0,
        textOnMachine: selectedOffenderhaircolour.value.textOnMachine,
        textOnLetter: selectedOffenderhaircolour.value.textOnLetter,
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
    <VCard :title="(props.selectedOffenderhaircolour.textOnMachine ? 'Edit' : 'Add New') + ' Offender Hair Colour' ">
      
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
              v-model="selectedOffenderhaircolour.textOnMachine"
              label="Text On Machine"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedOffenderhaircolour.textOnLetter"
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
