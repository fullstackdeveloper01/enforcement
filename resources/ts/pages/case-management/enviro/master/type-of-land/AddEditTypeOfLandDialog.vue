<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { TypeOfLandProperties } from '@/pages/case-management/enviro/master/type-of-land/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedTypeofland: TypeOfLandProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'typeoflandaddData', value: TypeOfLandProperties): void
  (e: 'typeoflandupdateData', value: TypeOfLandProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedTypeofland: () => ({
    id: 0,
  name: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedTypeofland = ref<TypeOfLandProperties>(structuredClone(toRaw(props.selectedTypeofland)))
watch(props, () => {
  selectedTypeofland.value = structuredClone(toRaw(props.selectedTypeofland))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const name = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedTypeofland.value = structuredClone(toRaw(props.selectedTypeofland))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedTypeofland.value.id>0){
        
        emit('typeoflandupdateData', selectedTypeofland.value)
      }
      else{
        
        emit('typeoflandaddData', {
        id:0,
        name: selectedTypeofland.value.name,
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
    <VCard :title="(props.selectedTypeofland.name ? 'Edit' : 'Add New') + ' Type Of Land' ">
      
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
              v-model="selectedTypeofland.name"
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
