<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { OffenderBuildProperties } from '@/pages/case-management/enviro/master/offender-build/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedOffenderbuild: OffenderBuildProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'offenderbuildaddData', value: OffenderBuildProperties): void
  (e: 'offenderbuildupdateData', value: OffenderBuildProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedOffenderbuild: () => ({
    id: 0,
  textOnMachine: '',
  textOnLetter: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedOffenderbuild = ref<OffenderBuildProperties>(structuredClone(toRaw(props.selectedOffenderbuild)))
watch(props, () => {
  selectedOffenderbuild.value = structuredClone(toRaw(props.selectedOffenderbuild))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedOffenderbuild.value = structuredClone(toRaw(props.selectedOffenderbuild))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedOffenderbuild.value.id>0){
        
        emit('offenderbuildupdateData', selectedOffenderbuild.value)
      }
      else{
        
        emit('offenderbuildaddData', {
        id:0,
        textOnMachine: selectedOffenderbuild.value.textOnMachine,
        textOnLetter: selectedOffenderbuild.value.textOnLetter,
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
    <VCard :title="(props.selectedOffenderbuild.textOnMachine ? 'Edit' : 'Add New') + ' Offender Build' ">
      
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
              v-model="selectedOffenderbuild.textOnMachine"
              label="Text On Machine"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedOffenderbuild.textOnLetter"
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
