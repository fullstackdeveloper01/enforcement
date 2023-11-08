<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { BwcProperties } from '@/pages/case-management/enviro/master/bwc/types';

import { requiredValidator } from '@validators';

interface Props {
  isDialogOpen: boolean,
  selectedBwc: BwcProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'bwcaddData', value: BwcProperties): void
  (e: 'bwcupdateData', value: BwcProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedBwc: () => ({
    id: 0,
    bwcNumber: '',
    name: '',
    status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedBwc = ref<BwcProperties>(structuredClone(toRaw(props.selectedBwc)))
watch(props, () => {
  selectedBwc.value = structuredClone(toRaw(props.selectedBwc))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const bwcNumber = ref('')
const name = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedBwc.value = structuredClone(toRaw(props.selectedBwc))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedBwc.value.id>0){        
        emit('bwcupdateData', selectedBwc.value)
      }
      else{        
        emit('bwcaddData', {
          id:0,
          bwcNumber: selectedBwc.value.bwcNumber,
          name: selectedBwc.value.name,
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
    <VCard :title="(props.selectedBwc.bwcNumber ? 'Edit' : 'Add New') + ' BWC' ">
      
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
              v-model="selectedBwc.bwcNumber"
              label="BWC Number"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedBwc.name"
              label="Officer/Site Name"
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
