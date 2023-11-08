<script lang="ts" setup>
import { useLegislationListStore } from '@/pages/case-management/enviro/master/legislation/useLegislationListStore';
import { useOffenceGroupListStore } from '@/pages/case-management/enviro/master/offence-group/useOffenceGroupListStore';
import { useOffenceListStore } from '@/pages/case-management/enviro/master/offence/useOffenceListStore';
import { integerValidator, requiredValidator } from "@validators";

import { VForm } from "vuetify/components";

const route = useRoute()
const router = useRouter()
const legislationListStore = useLegislationListStore()
const offenceGroupListStore = useOffenceGroupListStore()
const offenceListStore = useOffenceListStore()
const isTableLoading = ref(false)
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const englishLegislationList = ref([]);
const welshLegislationList = ref([]);
const offenceGroupList = ref([]);
const refOffenceEditForm = ref<VForm>();
const issueTypeList = [{id:1, name: "Penelty"}, {id:2, name: "Notice"}];

const offenceData = ref({
  name: null,
  welshName:null,
  description:null,
  welshDescription:null,
  englishLegislation:null,
  welshLegislation:null,
  group:null,
  minImageRequired:null,
  maxFine:null,
  issueType:null,
  status:null
});

offenceListStore.fetchOffenceById(Number(route.params.id)).then(response => {
  offenceData.value = response.data.data
}).catch(e => {
  const { message } = e.response.data;
  alertMessage.value=message
  alertType.value='error'
  isAlertVisible.value=true
})

//Fetch offence Group list
offenceGroupListStore.fetchOffenceGroupItems({
  status: '1',
}).then(response => {
  console.log(response.data.data)
  offenceGroupList.value = response.data.data
}).catch(e => {
  const { message } = e.response.data;
  alertMessage.value=message
  alertType.value='error'
  isAlertVisible.value=true
})

//Fetch legislation list
legislationListStore.fetchLegislationItems({
  status: '1',
}).then(response => {
  englishLegislationList.value = filter(response.data, 'english');
  welshLegislationList.value = filter(response.data, 'welsh');
}).catch(e => {
  const { message } = e.response.data;
  alertMessage.value=message
  alertType.value='error'
  isAlertVisible.value=true
})

const filter = (list, language:string) => {
  const legislation = list.filter(site => site.language.toLowerCase() === language);
  return legislation ? legislation : [];
}

const onSubmit = () => {
  refOffenceEditForm.value?.validate().then(({ valid: isValid }) => {
      if (isValid) {
        isTableLoading.value = true;
        offenceListStore.updateOffence(offenceData.value).then(response => {
            isTableLoading.value = false;
            alertMessage.value=response.data.message
            alertType.value='success'
            isAlertVisible.value=true
            router.push({name:'offence'});
        }).catch(e => {
            const { message } = e.response.data;
            alertMessage.value = message
            alertType.value ='error'
            isAlertVisible.value = true
            isTableLoading.value = false;
        })
      }
  }); 
};

</script>

<template>
  <div> 
    <VCard title="Edit Offence" class="mb-6">
      <VForm class="mt-2" ref="refOffenceEditForm" @submit.prevent="onSubmit">
        <VCardText>            
          <VRow>                
            <VCol md="6" cols="12">
              <VTextField
                v-model="offenceData.name"
                label="Offence Name"
                :rules="[requiredValidator]"
              />
            </VCol>
            <VCol md="6" cols="12">
              <VTextField
                v-model="offenceData.welshName"
                label="Offence Name (Welsh)"
              />
            </VCol>
            <VCol md="6" cols="12">
              <VSelect
                v-model="offenceData.englishLegislation"
                :items="englishLegislationList"
                label="Offence Legislation (English)"
                :rules="[requiredValidator]"
                item-title="legislation"
                item-value="id"
              />
            </VCol>
            <VCol md="6" cols="12">
              <VSelect
                v-model="offenceData.welshLegislation"
                :items="welshLegislationList"
                label="Offence Legislation (Welsh)"
                item-title="legislation"
                item-value="id"
              />
            </VCol>
            <VCol md="6" cols="12">
              <VSelect
                v-model="offenceData.group"
                :items="offenceGroupList"
                label="Offence Group"
                item-title="englishName"
                item-value="id"
                :rules="[requiredValidator]"
              />
            </VCol>
            <VCol md="6" cols="12">
              <VSelect
                v-model="offenceData.issueType"
                :items="issueTypeList"
                label="Enviro. Issue Type"
                item-title="name"
                item-value="id"
                :rules="[requiredValidator]"
              />
            </VCol>
            <VCol md="6" cols="12">
              <VTextField
                v-model="offenceData.maxFine"                      
                label="Maximum Fine"
                :rules="[requiredValidator,integerValidator]"
              />
            </VCol>
            <VCol md="6" cols="12">
              <VTextField
                v-model="offenceData.minImageRequired"
                label="Minimum Images Required"
                :rules="[requiredValidator,integerValidator]"
              />
            </VCol> 
            <VCol md="6" cols="12">
              <VTextarea
                v-model="offenceData.description"
                label="Offence Description"
              />
            </VCol>  
            <VCol md="6" cols="12">
              <VTextarea
                v-model="offenceData.welshDescription"
                label="Offence Description (Welsh)"
              />
            </VCol>    
          </VRow>
        </VCardText>

        <VDivider />

        <VCardText class="d-flex gap-4">
          <VBtn
            :loading="isTableLoading"
            :disabled="isTableLoading"
            type="submit"
            @click="refOffenceEditForm?.validate()"
          >Save</VBtn>
          <VBtn color="secondary" variant="tonal" type="button" :to="{ name: 'offence' }">
            Back
          </VBtn>
        </VCardText>
      </VForm>
    </VCard>
    <VSnackbar
        v-model="isAlertVisible"
        transition="fade-transition"
        location="top center"
        variant="flat"
        :color="alertType"
    >
        {{alertMessage}}
        <template #actions>
          <VBtn color="white" @click="isAlertVisible = false" >
            Close      
          </VBtn>      
        </template>
    </VSnackbar>
  </div> 
</template>