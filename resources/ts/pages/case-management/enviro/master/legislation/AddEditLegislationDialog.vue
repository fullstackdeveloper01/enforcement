<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { LegislationProperties } from '@/pages/case-management/enviro/master/legislation/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedLegislation: LegislationProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'legislationaddData', value: LegislationProperties): void
  (e: 'legislationupdateData', value: LegislationProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedLegislation: () => ({
    id: 0,
  title: '',
  legislation: '',
  language: '',
  offenceSpecificText: '',
  status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedLegislation = ref<LegislationProperties>(structuredClone(toRaw(props.selectedLegislation)))
watch(props, () => {
  selectedLegislation.value = structuredClone(toRaw(props.selectedLegislation))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const title = ref('')
const legislation = ref('')
const language = ref('')
const offenceSpecificText = ref('')
const loadings = ref<boolean[]>([]);
const languageList = [
  { name: "CY : Welsh", key: 'welsh' },
  { name: "En : English", key: 'english' },
];
// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedLegislation.value = structuredClone(toRaw(props.selectedLegislation))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedLegislation.value.id>0){
        
        emit('legislationupdateData', selectedLegislation.value)
      }
      else{
        
        emit('legislationaddData', {
        id:0,
        title: selectedLegislation.value.title,
        legislation: selectedLegislation.value.legislation,
        language: selectedLegislation.value.language,
        offenceSpecificText: selectedLegislation.value.offenceSpecificText,
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
    <VCard :title="(props.selectedLegislation.title ? 'Edit' : 'Add New') + ' Legislation' ">
      
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
              v-model="selectedLegislation.title"
              label="Title"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedLegislation.legislation"
              label="Legislation"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
           
            md="6"
          >
            <VTextField
              v-model="selectedLegislation.offenceSpecificText"
              label="Offence Specific Text"
              :rules="[requiredValidator]"
            />
          </VCol>
          <VCol
            cols="12"
            md="6"
          >
            <VSelect
                      v-model="selectedLegislation.language"
                      :items="languageList"
                      label="Select Language"
                      item-title="name"
                      item-value="key"
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
