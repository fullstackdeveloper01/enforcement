<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { DogSizeProperties } from '@/pages/case-management/enviro/master/dog-size/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedDogsize: DogSizeProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'dogsizeaddData', value: DogSizeProperties): void
  (e: 'dogsizeupdateData', value: DogSizeProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedDogsize: () => ({
    id: 0,
  name: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedDogsize = ref<DogSizeProperties>(structuredClone(toRaw(props.selectedDogsize)))
watch(props, () => {
  selectedDogsize.value = structuredClone(toRaw(props.selectedDogsize))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const name = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedDogsize.value = structuredClone(toRaw(props.selectedDogsize))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedDogsize.value.id>0){
        
        emit('dogsizeupdateData', selectedDogsize.value)
      }
      else{
        
        emit('dogsizeaddData', {
        id:0,
        name: selectedDogsize.value.name,
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
    max-width="400"
  >
   
    <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="onSubmit"
          >
    <!-- Dialog Content -->
    <VCard :title="(props.selectedDogsize.name ? 'Edit' : 'Add New') + ' Dog Size' ">
      
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
              v-model="selectedDogsize.name"
              label="Name"
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
