<script lang="ts" setup>
import axios from "@axios";
import { requiredValidator } from "@validators";
import { VForm } from "vuetify/components";
const loadings = ref<boolean[]>([]);

const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const siteList = ref([]);
const zoneWardList = ref([]);
const officerList = ref([]);
const offenceList = ref([]);
const ethnicityList = ref([]);
const offenceTypeList = ref([]);
const adminList = ref([]);
const prefixList = ref([]);
const locationList = ref([]);
const actionList = ref([]);
const typeOfLandList = ref([]);
const townAreaList = ref([]);
const POIprefixList = ref([]);
const visibilityList = ref([]);
const weatherList = ref([]);
const proofOfAddressList = ref([]);
const proofIdList = ref([]);
const dateError = ref(false);
var loading = true;
const showOffences = ref(true);

const errors = ref({
  site: "Please Select Site",
});
const enviroData = ref({
  site_id: null,
  request_type_id: null,
  busniness_waste_status: null,
  complaint_option_status: null,
  title:null,
  job_title: null,
  first_name: null,
  last_name: null,
  home_telephone: null,
  work_telephone: null,
  address: null,
  email: null,
  busniness_name: null,
  busniness_address: null,
  busniness_town: null,
  busniness_country: null,
  busniness_post_code: null,
  reported_via_id: null,
  officer_id: null,
  address2: null,
  ethnicity: null,
  complaint_town: null,
  complaint_country: null,
  complaint_postal_code: null,
  gender: null,
  date_of_birth :null,
  ethnicity:null
});

const validateDates = () => {
  var offence_date = enviroData.value.offenceDateTime;
  var issue_date = enviroData.value.issueDateTime;
  
  if(offence_date == null || issue_date == null)
  {
      return;
  }

  offence_date = new Date(offence_date);
  issue_date = new Date(issue_date);

  if(issue_date <= offence_date)
  {
    dateError.value = true;
  }else{
    dateError.value = false;
  }

}

const tab = ref("issue-enviro");

const salutationList = [
  { name: "Mr", id: 'Mr' },
  { name: "Mrs", id: 'Mrs' },
  { name: "Miss", id: 'Miss' },
  { name: "Ms", id: 'Ms' },
];

const languageList = [
  { name: "English", id: 'English' },
  { name: "Welsh", id: 'Welsh' },
];
const genderList = [
  { name: "Male", id: 'Male' },
  { name: "Female", id: 'Female' },
];

// Fetch Sites
const fetchSites = async() => {
  let response = await axios.get('/api/sites');
  let objects = await response.data.data;
  let lists:any = [];
  objects.forEach((item: any) => {
    let id = item.id;
    let name = item.name;
    let list = {
      id: id,
      name: name
    }
    lists.push(list)
    siteList.value = lists;
  });
}

// Fetch Zones
const fetchZones = async() => {
    enviroData.value.zone_id = null;
    enviroData.value.offence_id = null;
    var selectedSiteId = enviroData.value.site_id;
    if (selectedSiteId) {
      showOffences.value = false;

      try {
        const response = await axios.get(`/api/site/${selectedSiteId}/zones`);
        const zoneData = response.data;
        if(zoneData.success)
        {
          zoneWardList.value = zoneData.data;
        }
      } catch (error) {
        console.error(error);
      }
    } else {
      zoneWardList.value = [];
    }

    fetchTowns();
}

// Fetch Towns by site_id
const fetchTowns = async() => {
  enviroData.value.townArea = null;
  let site_id = enviroData.value.site_id;
  if(site_id)
  {
    try {
      const response = await axios.get(`/api/zone/${site_id}/towns`);
      const zoneData = response.data;
      townAreaList.value = zoneData;
    } catch (error) {
      console.error(error);
    }
  }
  else{
    townAreaList.value = [];
  }
}

// Fetch Ethnicity
const fetchEthnicity = async() => {
  let response = await axios.get('/api/ethnicity/fetch');
  let ethData = await response.data;
  ethnicityList.value = ethData;
}

// Fetch Officers
const fetchOfficers = async() => {
  let response = await axios.get('/api/officers/fetch');
  let officersData = await response.data;
  // const officerRows = officersData.data;
  officerList.value = officersData;
}

// Fetch Offence Groups
const fetchOffenceGroups = async() => {
  let response = await axios.get('/api/offence-groups/fetch');
  let groupsData = await response.data;
  offenceList.value = groupsData;
}

// Fetch Offence Type
const fetchOffenceTypes = async() => {

  enviroData.value.offence_type_id = null;
  var selectedId = enviroData.value.offence_id;
  let site_id = enviroData.value.site_id;
  if (selectedId) {

    let response = await axios.get('/api/sites/'+site_id+'/offence-type/'+selectedId+'/fetch');
    let offenceTypesData = await response.data;
    offenceTypeList.value = offenceTypesData;

  }
}

// Fetch Admins
const fetchAdmins = async() => {
  let response = await axios.get('/api/admin-users');
  let adminsData = await response.data;
  adminList.value = adminsData;
}

// Fetch Location Prefix
const fetchLocationPrefix = async() => {
  let response = await axios.get('/api/location/prefix/fetch');
  let data = await response.data;
  prefixList.value = data;
  POIprefixList.value = data;
}

// Fetch Location Sufix
const fetchLocationSufix = async() => {
  let response = await axios.get('/api/location/sufix/fetch');
  let data = await response.data;
  locationList.value = data;
}

// Fetch Action List
const fetchActionList = async() => {
  let response = await axios.get('/api/actions/fetch');
  let data = await response.data;
  actionList.value = data;
}

// Fetch Type of Land
const fetchLandType = async() => {
  let response = await axios.get('/api/land/fetch');
  let data = await response.data;
  typeOfLandList.value = data;
}

// Fetch Type of Land
const fetchVisibility = async() => {
  let response = await axios.get('/api/visibility/fetch');
  let data = await response.data;
  visibilityList.value = data;
}

// Fetch weather List
const fetchWeatherList = async() => {
  let response = await axios.get('/api/weather/fetch');
  let data = await response.data;
  weatherList.value = data;
}

// Fetch proofOfAddressList
const fetchProofAddressList = async() => {
  let response = await axios.get('/api/address/proof/fetch');
  let data = await response.data;
  proofOfAddressList.value = data;
}

// Fetch proofIdList
const fetchProofIdList = async() => {
  let response = await axios.get('/api/proof_ids/fetch');
  let data = await response.data;
  proofIdList.value = data;
}

onMounted(async () => {
  await fetchSites();
  await fetchOfficers();
  await fetchOffenceGroups();
  await fetchAdmins();
  await fetchEthnicity();
  await fetchProofAddressList();
  await fetchProofIdList();
  await fetchLocationPrefix();
  await fetchLocationSufix();
  await fetchActionList();
  await fetchLandType();
  await fetchVisibility();
  await fetchWeatherList();
});


const requestAddForm = ref<VForm>();
const issueEnviro = () => {
  var envroSubmitData = enviroData.value;
  
  // loadings.value[0] = true;
  axios
    .post("api/createServiceRequest", envroSubmitData)
    .then((r) => {
      console.log(r);
      // loadings.value[0] = false;
      alertMessage.value="Service Request successfully added"
      alertType.value='success'
      isAlertVisible.value=true
      
    })
    .catch((e) => {
      console.log(e);
      /* const { errors: formErrors } = e.response.data;
      errors.value = formErrors; */
    });
};
const onSubmit = () => {
  requestAddForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid) issueEnviro();
  }); 
};

</script>

<template>
  <VCard title="Service Request" class="mb-6">
    
    <VTabs v-model="tab">
      <VTab value="issue-enviro"> Issue Service Request. </VTab>
      <VTab value="officer-notes"> Officer Notes </VTab>
      <VTab value="witness-statement"> Witness Statement </VTab>
    </VTabs>
    <VForm class="mt-2" ref="requestAddForm" @submit.prevent="onSubmit">
      <VCardText>
        <VWindow class="py-2" v-model="tab">
          <VWindowItem value="issue-enviro">
            <VCard title="" class="mb-6 border">
              <VCardText>
                <VRow>
                  <VCol md="6" cols="12" v-if="siteList.length > 0">
                    <VSelect
                      v-model="enviroData.site_id"
                      :items="siteList"
                      label="-- Select Site --"
                      item-title="name"
                      item-value="id"
                      @update:modelValue="fetchZones"
                      :rules="[requiredValidator]"
                    />
                  </VCol>

                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.request_type_id"
                      :items="languageList"
                      label="-- Select Request Type --"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                  /></VCol>
                    <VCol cols="12" md="6">
                    <VLabel class="mb-2"> Busniness Waste </VLabel>
                    <VRadioGroup
                      v-model="enviroData.busniness_waste_status"
                      :rules="[requiredValidator]"
                      inline
                    >
                      <VRadio label="Yes" value="1" />
                      <VRadio label="No" value="0" />
                    </VRadioGroup>
                  </VCol>

                     <VCol cols="12" md="6">
                    <VLabel class="mb-2">Complaint Option </VLabel>
                    <VRadioGroup
                      v-model="enviroData.complaint_option_status"
                      :rules="[requiredValidator]"
                      inline
                    >
                      <VRadio label="Provide Details" value="1" />
                      <VRadio label="Remain Anonymous" value="0" />
                    </VRadioGroup>
                  </VCol>
                 
                </VRow>
              </VCardText>
            </VCard>
            <VCard title="Complaint Details" class="mb-6 border">
              <VCardText>
                <VRow>
                  <VCol md="6" cols="12">
                    <VSelect
                      v-model="enviroData.title"
                      :items="salutationList"
                      label="-- Select Title --"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                    />
                  </VCol>

                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.job_title"
                      label="Job Title"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.first_name"
                      label="First name"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.home_telephone"
                      label="Home - Telephone"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.last_name"
                      label="Last Name"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField v-model="enviroData.work_telephone" label="Work - Telephone" :rules="[requiredValidator]"  />

                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.address"
                      label="Address 1"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.email"
                      label="E-Mail"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
            <VCard title="Busniness Waste Details" class="mb-6 border">
              <VCardText>
                <VRow>
                 <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.busniness_name"
                      label="Busniness Name"
                      :rules="[requiredValidator]"
                    />
                  </VCol> 
                   <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.busniness_town"
                      label="Busniness Town"
                      :rules="[requiredValidator]"
                    />
                  </VCol> 
               <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.busniness_address"
                      label="Busniness Address"
                      :rules="[requiredValidator]"
                    />
                  </VCol> 

                 <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.busniness_country"
                      label="Busniness Country"
                      :rules="[requiredValidator]"
                    />
                  </VCol> 
                
                 <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.busniness_post_code"
                      label="Busniness Post Code"
                      :rules="[requiredValidator]"
                    />
                  </VCol> 
                   <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.address2"
                      label="Address 2"
                      :rules="[requiredValidator]"
                    />
                  </VCol> 
                   <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.complaint_town"
                      label="Town"
                      :rules="[requiredValidator]"
                    />
                  </VCol> 
                    <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.complaint_country"
                      label="Complaint Country"
                      :rules="[requiredValidator]"
                    />
                  </VCol> 
                    <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.complaint_postal_code"
                      label="Complaint Postal Code"
                      :rules="[requiredValidator]"
                    />
                  </VCol> 
                   <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.gender"
                      :items="genderList"
                      label="-- Select Gender --"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                  /></VCol>
                    <VCol md="6" cols="12">
                    <AppDateTimePicker
                      v-model="enviroData.date_of_birth"
                      label="Date Of Birth"
                      :config="{ enableTime: true, dateFormat: 'Y-m-d H:i' }"
                      :rules="[requiredValidator]"
                      @update:modelValue="validateDates"
                    />
                    <small style="color:red" v-if="dateError">*Issue date should be greater than offence date</small> 
                  </VCol>
                   <VCol md="6" cols="12" v-if="siteList.length > 0">
                    <VSelect
                      v-model="enviroData.ethnicity"
                      :items="siteList"
                      label="-- Select Ethnicity --"
                      item-title="name"
                      item-value="id"
                      @update:modelValue="fetchZones"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
            <VCard title="Service Request Information" class="mb-6 border">
              <VCardText>
                <VRow>
                  <VCol md="6" cols="12" v-if="siteList.length > 0">
                    <VSelect
                      v-model="enviroData.reported_via_id"
                      :items="siteList"
                      label="-- Select Reported Via --"
                      item-title="name"
                      item-value="id"
                      @update:modelValue="fetchZones"
                      :rules="[requiredValidator]"
                    />
                  </VCol>

                    <VCol md="6" cols="12" v-if="siteList.length > 0">
                    <VSelect
                      v-model="enviroData.officer_id"
                      :items="siteList"
                      label="-- Select Officer --"
                      item-title="name"
                      item-value="id"
                      @update:modelValue="fetchZones"
                      :rules="[requiredValidator]"
                    />
                  </VCol>

                </VRow>
              </VCardText>
            </VCard>
          </VWindowItem>

          <VWindowItem value="officer-notes"> </VWindowItem>

          <VWindowItem value="witness-statement"> </VWindowItem>
        </VWindow>
      </VCardText>

      <VDivider />

      <VCardText class="d-flex gap-4">
        <VBtn
          :loading="loadings[0]"
          :disabled="loadings[0]"
          type="submit"
          @click="requestAddForm?.validate()"
          >Save</VBtn
        >
        <VBtn color="secondary" variant="tonal">
          Save & Refer to Prosecution
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
</template>
