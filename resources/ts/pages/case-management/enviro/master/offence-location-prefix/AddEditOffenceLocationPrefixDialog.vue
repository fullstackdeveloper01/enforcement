<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { OffenceLocationPrefixProperties } from '@/pages/case-management/enviro/master/offence-location-prefix/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedOffencelocationprefix: OffenceLocationPrefixProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'offencelocationprefixaddData', value: OffenceLocationPrefixProperties): void
  (e: 'offencelocationprefixupdateData', value: OffenceLocationPrefixProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedOffencelocationprefix: () => ({
    id: 0,
  textOnMachine: '',
  textOnLetter: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedOffencelocationprefix = ref<OffenceLocationPrefixProperties>(structuredClone(toRaw(props.selectedOffencelocationprefix)))
watch(props, () => {
  selectedOffencelocationprefix.value = structuredClone(toRaw(props.selectedOffencelocationprefix))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedOffencelocationprefix.value = structuredClone(toRaw(props.selectedOffencelocationprefix))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedOffencelocationprefix.value.id>0){
        
        emit('offencelocationprefixupdateData', selectedOffencelocationprefix.value)
      }
      else{
        
        emit('offencelocationprefixaddData', {
        id:0,
        textOnMachine: selectedOffencelocationprefix.value.textOnMachine,
        textOnLetter: selectedOffencelocationprefix.value.textOnLetter,
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
    <VCard :title="(props.selectedOffencelocationprefix.textOnMachine ? 'Edit' : 'Add New') + ' Offence Location Prefix' ">
      
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
              v-model="selectedOffencelocationprefix.textOnMachine"
              label="Text On Machine"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedOffencelocationprefix.textOnLetter"
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
