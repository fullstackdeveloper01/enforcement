<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { WeatherProperties } from '@/pages/case-management/enviro/master/weather/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedWeather: WeatherProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'weatheraddData', value: WeatherProperties): void
  (e: 'weatherupdateData', value: WeatherProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedWeather: () => ({
    id: 0,
  textOnMachine: '',
  textOnLetter: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedWeather = ref<WeatherProperties>(structuredClone(toRaw(props.selectedWeather)))
watch(props, () => {
  selectedWeather.value = structuredClone(toRaw(props.selectedWeather))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedWeather.value = structuredClone(toRaw(props.selectedWeather))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedWeather.value.id>0){
        
        emit('weatherupdateData', selectedWeather.value)
      }
      else{
        
        emit('weatheraddData', {
        id:0,
        textOnMachine: selectedWeather.value.textOnMachine,
        textOnLetter: selectedWeather.value.textOnLetter,
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
    <VCard :title="(props.selectedWeather.textOnMachine ? 'Edit' : 'Add New') + ' Weather' ">
      
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
              v-model="selectedWeather.textOnMachine"
              label="Text On Machine"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedWeather.textOnLetter"
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
