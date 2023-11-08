<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { TypeOfDogProperties } from '@/pages/case-management/enviro/master/type-of-dog/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedTypeofdog: TypeOfDogProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'typeofdogaddData', value: TypeOfDogProperties): void
  (e: 'typeofdogupdateData', value: TypeOfDogProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedTypeofdog: () => ({
    id: 0,
  name: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedTypeofdog = ref<TypeOfDogProperties>(structuredClone(toRaw(props.selectedTypeofdog)))
watch(props, () => {
  selectedTypeofdog.value = structuredClone(toRaw(props.selectedTypeofdog))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const name = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedTypeofdog.value = structuredClone(toRaw(props.selectedTypeofdog))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedTypeofdog.value.id>0){
        
        emit('typeofdogupdateData', selectedTypeofdog.value)
      }
      else{
        
        emit('typeofdogaddData', {
        id:0,
        name: selectedTypeofdog.value.name,
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
    <VCard :title="(props.selectedTypeofdog.name ? 'Edit' : 'Add New') + ' Type Of Dog' ">
      
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
              v-model="selectedTypeofdog.name"
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
