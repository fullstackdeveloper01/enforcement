<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { WriteOffCodeProperties } from '@/pages/case-management/enviro/master/write-off-code/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedWriteoffcode: WriteOffCodeProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'writeoffcodeaddData', value: WriteOffCodeProperties): void
  (e: 'writeoffcodeupdateData', value: WriteOffCodeProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedWriteoffcode: () => ({
    id: 0,
  type: '',
  description: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedWriteoffcode = ref<WriteOffCodeProperties>(structuredClone(toRaw(props.selectedWriteoffcode)))
watch(props, () => {
  selectedWriteoffcode.value = structuredClone(toRaw(props.selectedWriteoffcode))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const type = ref('')
const description = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedWriteoffcode.value = structuredClone(toRaw(props.selectedWriteoffcode))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedWriteoffcode.value.id>0){
        
        emit('writeoffcodeupdateData', selectedWriteoffcode.value)
      }
      else{
        
        emit('writeoffcodeaddData', {
        id:0,
        type: selectedWriteoffcode.value.type,
        description: selectedWriteoffcode.value.description,
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
    <VCard :title="(props.selectedWriteoffcode.type ? 'Edit' : 'Add New') + ' Write Off Code' ">
      
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
              v-model="selectedWriteoffcode.type"
              label="Write Off Code"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedWriteoffcode.description"
              label="Write Off Code Description"
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
