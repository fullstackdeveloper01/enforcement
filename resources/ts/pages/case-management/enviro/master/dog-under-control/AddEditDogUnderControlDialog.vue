<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { DogUnderControlProperties } from '@/pages/case-management/enviro/master/dog-under-control/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedDogundercontrol: DogUnderControlProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'dogundercontroladdData', value: DogUnderControlProperties): void
  (e: 'dogundercontrolupdateData', value: DogUnderControlProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedDogundercontrol: () => ({
    id: 0,
  name: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedDogundercontrol = ref<DogUnderControlProperties>(structuredClone(toRaw(props.selectedDogundercontrol)))
watch(props, () => {
  selectedDogundercontrol.value = structuredClone(toRaw(props.selectedDogundercontrol))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const name = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedDogundercontrol.value = structuredClone(toRaw(props.selectedDogundercontrol))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedDogundercontrol.value.id>0){
        
        emit('dogundercontrolupdateData', selectedDogundercontrol.value)
      }
      else{
        
        emit('dogundercontroladdData', {
        id:0,
        name: selectedDogundercontrol.value.name,
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
    <VCard :title="(props.selectedDogundercontrol.name ? 'Edit' : 'Add New') + ' Dog Under Control' ">
      
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
              v-model="selectedDogundercontrol.name"
              label="Dog Under Control"
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
