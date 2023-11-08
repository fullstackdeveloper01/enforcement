<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';
import axios from "@axios"; 

import type { ServiceRequestTaskGroupProperties } from '@/pages/case-management/enviro/master/service-request-task-group/types';
import { siteStore } from '@/pages/setup/sites/siteStore';
import { useServiceRequestTaskTypeListStore } from '@/pages/case-management/enviro/master/service-request-task-type/useServiceRequestTaskTypeListStore';
import { useUserListStore } from '@/pages/admin/user/useUserListStore';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedServiceRequestTaskGroup: ServiceRequestTaskGroupProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'serviceRequestTaskGroupaddData', value: ServiceRequestTaskGroupProperties): void
  (e: 'serviceRequestTaskGroupupdateData', value: ServiceRequestTaskGroupProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedServiceRequestTaskGroup: () => ({
  id: 0,
  site_id:'',
  task_type_id:'',
  task_group_name:'',
  status: '',
  }),
})
//const props = defineProps<Props>()
const route = useRoute()
const userListStore = useUserListStore()
const ServiceRequestTaskTypeListStore = useServiceRequestTaskTypeListStore()
const siteStores = siteStore()
const emit = defineEmits<Emit>()
const selectedServiceRequestTaskGroup = ref<ServiceRequestTaskGroupProperties>(structuredClone(toRaw(props.selectedServiceRequestTaskGroup)))
watch(props, () => {
  selectedServiceRequestTaskGroup.value = structuredClone(toRaw(props.selectedServiceRequestTaskGroup))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);
const siteList = ref([]);
const taskTypeList = ref([]);


// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedServiceRequestTaskGroup.value = structuredClone(toRaw(props.selectedServiceRequestTaskGroup))
  
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
     loadings.value[0] = true;
      if(selectedServiceRequestTaskGroup.value.id>0){
        emit('ServiceRequestTaskGroupupdateData', selectedServiceRequestTaskGroup.value)
      }
      else{
        emit('ServiceRequestTaskGroupaddData', {
        id:0,
        site_id: selectedServiceRequestTaskGroup.value.site_id,
        task_type_id: selectedServiceRequestTaskGroup.value.task_type_id,
        task_group_name: selectedServiceRequestTaskGroup.value.task_group_name,
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

const changeSite = (id:number) => {
 console.log(id);
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




// Fetch Task Type
const fecthTaskType = async() => {
    var selectedSiteId = selectedServiceRequestTaskGroup.value.site_id;
    if (selectedSiteId) {

      try {
        const response = await axios.get(`/api/enviro/master/${selectedSiteId}/tasktype`);
        const taskTypeData = response.data;
        if(taskTypeData.success)
        {
          taskTypeList.value = taskTypeData.data;
          selectedServiceRequestTaskGroup.value.task_type_id = [];
        }
      } catch (error) {
        console.error(error);
      }
    } else {
      taskTypeList.value = [];
    }
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
    <VCard :title="(props.selectedServiceRequestTaskGroup.task_group_name ? 'Edit' : 'Add New') + ' Service Request Task Group' ">
      
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
                v-model="selectedServiceRequestTaskGroup.site_id"
                :items="siteList"
                label="Choose Site"
                item-title="name"
                item-value="id"
                :rules="[requiredValidator]"
                @update:modelValue="fecthTaskType"
              />
          </VCol>

          <VCol
            cols="12"
            md="12"
          >
            <VSelect
                v-model="selectedServiceRequestTaskGroup.task_type_id"
                :items="taskTypeList"
                label="Choose Task Type"
                item-title="task_type_name"
                item-value="id"
                multiple
                :rules="[requiredValidator]"
              />
          </VCol>

          <VCol
            cols="12"
            md="12"
          >
            <VTextField
              v-model="selectedServiceRequestTaskGroup.task_group_name"
              label="Task Group Name"
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
