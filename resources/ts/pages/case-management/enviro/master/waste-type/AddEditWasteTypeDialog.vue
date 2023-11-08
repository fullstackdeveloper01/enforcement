<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { WasteTypeProperties } from '@/pages/case-management/enviro/master/waste-type/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedWasteType: WasteTypeProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'wastetypeaddData', value: WasteTypeProperties): void
  (e: 'wastetypeupdateData', value: WasteTypeProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedWasteType: () => ({
    id: 0,
    waste_type:'',
    status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedWasteType = ref<WasteTypeProperties>(structuredClone(toRaw(props.selectedWasteType)))
watch(props, () => {
  selectedWasteType.value = structuredClone(toRaw(props.selectedWasteType))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedWasteType.value = structuredClone(toRaw(props.selectedWasteType))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedWasteType.value.id>0){
        
        emit('wastetypeupdateData', selectedWasteType.value)
      }
      else{
        emit('wastetypeaddData', {
        id:0,
        waste_type: selectedWasteType.value.waste_type,
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
    <VCard :title="(props.selectedWasteType.waste_type ? 'Edit' : 'Add New') + 'Waste Type' ">
      
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
              v-model="selectedWasteType.waste_type"
              label="Waste Type"
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
