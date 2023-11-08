<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { RegionProperties } from '@/pages/case-management/enviro/master/region/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedRegion: RegionProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'regionaddData', value: RegionProperties): void
  (e: 'regionupdateData', value: RegionProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedRegion: () => ({
    id: 0,
    region: '',
    status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedRegion = ref<RegionProperties>(structuredClone(toRaw(props.selectedRegion)))
watch(props, () => {
  selectedRegion.value = structuredClone(toRaw(props.selectedRegion))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const region = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedRegion.value = structuredClone(toRaw(props.selectedRegion))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedRegion.value.id>0){        
        emit('regionupdateData', selectedRegion.value)
      }
      else{        
        emit('regionaddData', {
          id:0,
          region: selectedRegion.value.region,
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
    <VCard :title="(props.selectedRegion.region ? 'Edit' : 'Add New') + ' Region' ">
      
      <DialogCloseBtn
        variant="text"
        size="large"
        @click="closeDialog"
      />

      <VCardText>
        <VRow>
          <VCol
            cols="12"           
            md="12"
          >
            <VTextField
              v-model="selectedRegion.region"
              label="Region Name"
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
