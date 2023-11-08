<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { EnviroProperties } from '@/pages/case-management/enviro/master/enviro/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedEnviro: EnviroProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'enviroaddData', value: EnviroProperties): void
  (e: 'enviroupdateData', value: EnviroProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedEnviro: () => ({
    id: 0,
  textOnMachine: '',
  textOnLetter: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedEnviro = ref<EnviroProperties>(structuredClone(toRaw(props.selectedEnviro)))
watch(props, () => {
  selectedEnviro.value = structuredClone(toRaw(props.selectedEnviro))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedEnviro.value = structuredClone(toRaw(props.selectedEnviro))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedEnviro.value.id>0){
        
        emit('enviroupdateData', selectedEnviro.value)
      }
      else{
        
        emit('enviroaddData', {
        id:0,
        textOnMachine: selectedEnviro.value.textOnMachine,
        textOnLetter: selectedEnviro.value.textOnLetter,
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
    <VCard :title="(props.selectedEnviro.textOnMachine ? 'Edit' : 'Add New') + ' Enviro' ">
      
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
              v-model="selectedEnviro.textOnMachine"
              label="Text On Machine"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedEnviro.textOnLetter"
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
