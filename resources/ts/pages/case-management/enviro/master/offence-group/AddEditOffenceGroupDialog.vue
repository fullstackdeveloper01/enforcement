<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { OffenceGroupProperties } from '@/pages/case-management/enviro/master/offence-group/types';

import { requiredValidator } from '@validators';

interface Props {
  isDialogOpen: boolean,
  selectedOffencegroup: OffenceGroupProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'offencegroupaddData', value: OffenceGroupProperties): void
  (e: 'offencegroupupdateData', value: OffenceGroupProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedOffencegroup: () => ({
    id: 0,
    englishName: '',
    welshName: '',
    type: '',
    status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedOffencegroup = ref<OffenceGroupProperties>(structuredClone(toRaw(props.selectedOffencegroup)))
watch(props, () => {
  selectedOffencegroup.value = structuredClone(toRaw(props.selectedOffencegroup))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedOffencegroup.value = structuredClone(toRaw(props.selectedOffencegroup))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedOffencegroup.value.id>0){        
        emit('offencegroupupdateData', selectedOffencegroup.value)
      }
      else{        
        emit('offencegroupaddData', {
          id:0,
          englishName: selectedOffencegroup.value.englishName,
          welshName: selectedOffencegroup.value.welshName,
          type: selectedOffencegroup.value.type,
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
    <VCard :title="(props.selectedOffencegroup.id >0 ? 'Edit' : 'Add New') + ' Offence Group' ">
      
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
              v-model="selectedOffencegroup.englishName"
              label="Offence Group Name(English)"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedOffencegroup.welshName"
              label="Offence Group Name(Welsh)"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="12"
          >
            <VTextField
              v-model="selectedOffencegroup.name"
              label="Offence Group Type"
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
