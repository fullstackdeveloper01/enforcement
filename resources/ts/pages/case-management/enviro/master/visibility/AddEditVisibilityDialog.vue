<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { VisibilityProperties } from '@/pages/case-management/enviro/master/visibility/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedVisibility: VisibilityProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'visibilityaddData', value: VisibilityProperties): void
  (e: 'visibilityupdateData', value: VisibilityProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedVisibility: () => ({
    id: 0,
  visibility: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedVisibility = ref<VisibilityProperties>(structuredClone(toRaw(props.selectedVisibility)))
watch(props, () => {
  selectedVisibility.value = structuredClone(toRaw(props.selectedVisibility))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const visibility = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedVisibility.value = structuredClone(toRaw(props.selectedVisibility))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedVisibility.value.id>0){
        
        emit('visibilityupdateData', selectedVisibility.value)
      }
      else{
        
        emit('visibilityaddData', {
        id:0,
        visibility: selectedVisibility.value.visibility,
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
    <VCard :title="(props.selectedVisibility.visibility ? 'Edit' : 'Add New') + ' Visibility' ">
      
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
              v-model="selectedVisibility.visibility"
              label="Visibility"
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
