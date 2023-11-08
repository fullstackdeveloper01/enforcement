<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { OffenceLocationSuffixProperties } from '@/pages/case-management/enviro/master/offence-location-suffix/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedOffencelocationsuffix: OffenceLocationSuffixProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'offencelocationsuffixaddData', value: OffenceLocationSuffixProperties): void
  (e: 'offencelocationsuffixupdateData', value: OffenceLocationSuffixProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedOffencelocationsuffix: () => ({
    id: 0,
  textOnMachine: '',
  textOnLetter: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedOffencelocationsuffix = ref<OffenceLocationSuffixProperties>(structuredClone(toRaw(props.selectedOffencelocationsuffix)))
watch(props, () => {
  selectedOffencelocationsuffix.value = structuredClone(toRaw(props.selectedOffencelocationsuffix))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedOffencelocationsuffix.value = structuredClone(toRaw(props.selectedOffencelocationsuffix))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedOffencelocationsuffix.value.id>0){
        
        emit('offencelocationsuffixupdateData', selectedOffencelocationsuffix.value)
      }
      else{
        
        emit('offencelocationsuffixaddData', {
        id:0,
        textOnMachine: selectedOffencelocationsuffix.value.textOnMachine,
        textOnLetter: selectedOffencelocationsuffix.value.textOnLetter,
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
    <VCard :title="(props.selectedOffencelocationsuffix.textOnMachine ? 'Edit' : 'Add New') + ' Offence Location Suffix' ">
      
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
              v-model="selectedOffencelocationsuffix.textOnMachine"
              label="Text On Machine"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedOffencelocationsuffix.textOnLetter"
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
