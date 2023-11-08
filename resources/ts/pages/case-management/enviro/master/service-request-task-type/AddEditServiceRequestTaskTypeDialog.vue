<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { ServiceRequestTaskTypeProperties } from '@/pages/case-management/enviro/master/service-request-task-type/types';
import { siteStore } from '@/pages/setup/sites/siteStore';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedServiceRequestTaskType: ServiceRequestTaskTypeProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'serviceRequestTaskTypeaddData', value: ServiceRequestTaskTypeProperties): void
  (e: 'serviceRequestTaskTypeupdateData', value: ServiceRequestTaskTypeProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedServiceRequestTaskType: () => ({
    id: 0,
  site_id:'',
  task_type_name:'',
  status: '',
  }),
})
//const props = defineProps<Props>()
const siteStores = siteStore()
const emit = defineEmits<Emit>()
const selectedServiceRequestTaskType = ref<ServiceRequestTaskTypeProperties>(structuredClone(toRaw(props.selectedServiceRequestTaskType)))
watch(props, () => {
  selectedServiceRequestTaskType.value = structuredClone(toRaw(props.selectedServiceRequestTaskType))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);
const siteList = ref([]);


// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedServiceRequestTaskType.value = structuredClone(toRaw(props.selectedServiceRequestTaskType))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedServiceRequestTaskType.value.id>0){
        emit('ServiceRequestTaskTypeupdateData', selectedServiceRequestTaskType.value)
      }
      else{
        emit('ServiceRequestTaskTypeaddData', {
        id:0,
        site_id: selectedServiceRequestTaskType.value.site_id,
        task_type_name: selectedServiceRequestTaskType.value.task_type_name,
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



siteStores.fetchAllSites().then(response => {
  let res = response.data.data;
  let lists:any = [];
   res.forEach((item: any) => {
    let id = item.id;
    let name = item.name;
    let list = {
      id: id,
      name: name
    }
    lists.push(list)
    siteList.value = lists;
  });
});

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
    <VCard :title="(props.selectedServiceRequestTaskType.task_type_name ? 'Edit' : 'Add New') + ' Service Request Task Type' ">
      
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
            <VSelect
                v-model="selectedServiceRequestTaskType.site_id"
                :items="siteList"
                label="Choose Site"
                item-title="name"
                item-value="id"
                :rules="[requiredValidator]"
              />
          </VCol>

          <VCol
            cols="12"
            md="12"
          >
            <VTextField
              v-model="selectedServiceRequestTaskType.task_type_name"
              label="Task Type Name"
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
