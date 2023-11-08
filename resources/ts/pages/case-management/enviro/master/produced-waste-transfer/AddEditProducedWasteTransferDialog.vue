<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { ProducedWasteTransferProperties } from '@/pages/case-management/enviro/master/produced-waste-transfer/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedProducedWasteTransfer: ProducedWasteTransferProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'producedwastetransferaddData', value: ProducedWasteTransferProperties): void
  (e: 'producedwastetransferupdateData', value: ProducedWasteTransferProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedProducedWasteTransfer: () => ({
    id: 0,
    waste_transfer:'',
    status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedProducedWasteTransfer = ref<ProducedWasteTransferProperties>(structuredClone(toRaw(props.selectedProducedWasteTransfer)))
watch(props, () => {
  selectedProducedWasteTransfer.value = structuredClone(toRaw(props.selectedProducedWasteTransfer))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedProducedWasteTransfer.value = structuredClone(toRaw(props.selectedProducedWasteTransfer))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedProducedWasteTransfer.value.id>0){
        
        emit('producedwastetransferupdateData', selectedProducedWasteTransfer.value)
      }
      else{
        emit('producedwastetransferaddData', {
        id:0,
        waste_transfer: selectedProducedWasteTransfer.value.waste_transfer,
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
    <VCard :title="(props.selectedProducedWasteTransfer.waste_transfer ? 'Edit' : 'Add New') + 'Produced Waste Transfer' ">
      
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
              v-model="selectedProducedWasteTransfer.waste_transfer"
              label="Waste Transfer"
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
