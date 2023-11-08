<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { CancelCodeProperties } from '@/pages/case-management/enviro/master/cancel-code/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedCancelcode: CancelCodeProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'cancelcodeaddData', value: CancelCodeProperties): void
  (e: 'cancelcodeupdateData', value: CancelCodeProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedCancelcode: () => ({
    id: 0,
  type: '',
  description: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedCancelcode = ref<CancelCodeProperties>(structuredClone(toRaw(props.selectedCancelcode)))
watch(props, () => {
  selectedCancelcode.value = structuredClone(toRaw(props.selectedCancelcode))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const type = ref('')
const description = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedCancelcode.value = structuredClone(toRaw(props.selectedCancelcode))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedCancelcode.value.id>0){
        
        emit('cancelcodeupdateData', selectedCancelcode.value)
      }
      else{
        
        emit('cancelcodeaddData', {
        id:0,
        type: selectedCancelcode.value.type,
        description: selectedCancelcode.value.description,
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
    <VCard :title="(props.selectedCancelcode.type ? 'Edit' : 'Add New') + ' Cancel Code' ">
      
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
              v-model="selectedCancelcode.type"
              label="Cancel Code"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedCancelcode.description"
              label="Cancel Code Description"
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
