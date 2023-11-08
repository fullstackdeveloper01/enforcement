<script lang="ts" setup>
import axios from "@axios";
import AppDateTimePicker from "@core/components/AppDateTimePicker.vue";
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
  zone_id: null,
  officer_id: null,
  offence_id: null,
  offence_type_id:null,
  language: null,
  admin: null,
  salutation: null,
  forename: null,
  surname: null,
  houseNo: null,
  town: null,
  county: null,
  postalCode: null,
  mobile: null,
  dateofbirth: null,
  ethnicity: null,
  gender: 'male',
  activeBWC: 'no',
  proofOfAddress: null,
  proofId: null,
  refNo: null,
  prefix: null,
  location: null,
  action: null,
  caution: null,
  secondCaution: null,
  offenderReply: 'no',
  description: null,
  descriptionOfWaste: null,
  offenceLocation: null,
  typeOfLand: null,
  townArea: null,
  POIprefix: null,
  POI: null,
  visibility: null,
  weather: null,
  offenceDateTime: null,
  issueDateTime: null,
  enviroIssueOnSpot: null,
  isWitnessAvailable: 'no',
  officerStatement: null,
             
         
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


const refEnviroAddForm = ref<VForm>();
const issueEnviro = () => {
  var envroSubmitData = enviroData.value;
  
  // loadings.value[0] = true;
  axios
    .post("/api/enviro", envroSubmitData)
    .then((r) => {
      console.log(r);
      // loadings.value[0] = false;
      alertMessage.value="Enviro successfully added"
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
  refEnviroAddForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid) issueEnviro();
  }); 
};

</script>

<template>
  <VCard title="Issue Enviro." class="mb-6">
    
    <VTabs v-model="tab">
      <VTab value="issue-enviro"> Issue Enviro. </VTab>
      <VTab value="officer-notes"> Officer Notes </VTab>
      <VTab value="witness-statement"> Witness Statement </VTab>
    </VTabs>
    <VForm class="mt-2" ref="refEnviroAddForm" @submit.prevent="onSubmit">
      <VCardText>
        <VWindow class="py-2" v-model="tab">
          <VWindowItem value="issue-enviro">
            <VCard title="Offence Details" class="mb-6 border">
              <VCardText>
                <VRow>
                  <VCol md="6" cols="12" v-if="siteList.length > 0">
                    <VSelect
                      v-model="enviroData.site_id"
                      :items="siteList"
                      label="Site"
                      item-title="name"
                      item-value="id"
                      @update:modelValue="fetchZones"
                      :rules="[requiredValidator]"
                    />
                  </VCol>

                  <VCol md="6" cols="12">
                    <VSelect
                      v-model="enviroData.zone_id"
                      :items="zoneWardList"
                      label="Zone/Ward"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                    />
                  </VCol>

                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.officer_id"
                      :items="officerList"
                      label="Officer"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                    />
                  </VCol>

                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.offence_id"
                      :items="offenceList"
                      label="Offence"
                      item-title="name"
                      item-value="id"
                      :disabled="showOffences"
                      @update:modelValue="fetchOffenceTypes"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.offence_type_id"
                      :items="offenceTypeList"
                      label="Offence Type"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.language"
                      :items="languageList"
                      label="Language"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                  /></VCol>
                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.admin"
                      :items="adminList"
                      label="Admin"
                      item-title="name"
                      item-value="id"
                    />
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
            <VCard title="Offender Details" class="mb-6 border">
              <VCardText>
                <VRow>
                  <VCol md="6" cols="12">
                    <VSelect
                      v-model="enviroData.salutation"
                      :items="salutationList"
                      label="Salutation"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                    />
                  </VCol>

                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.forename"
                      label="Forename"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.surname"
                      label="Surname"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.houseNo"
                      label="House No. & Road"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.town"
                      label="Town"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField v-model="enviroData.county" label="County" />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.postalCode"
                      label="Postal Code"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.mobile"
                      label="Mobile No."
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <AppDateTimePicker
                      v-model="enviroData.dateofbirth"
                      label="Date of Birth"
                    />
                  </VCol>
                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.ethnicity"
                      :items="ethnicityList"
                      label="Ethnicity"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                  /></VCol>
                  <VCol cols="12" md="6">
                    <VLabel class="mb-2"> Gender </VLabel>
                    <VRadioGroup
                      v-model="enviroData.gender"
                      :rules="[requiredValidator]"
                      inline
                    >
                      <VRadio label="Male" value="male" />
                      <VRadio label="Female" value="female" />
                    </VRadioGroup>
                  </VCol>
                  <VCol cols="12" md="6">
                    <VLabel class="mb-2"> Active BWC </VLabel>
                    <VRadioGroup
                      v-model="enviroData.activeBWC"
                      :rules="[requiredValidator]"
                      inline
                    >
                      <VRadio label="Yes" value="yes" />
                      <VRadio label="No" value="no" />
                    </VRadioGroup>
                  </VCol>

                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.proofOfAddress"
                      :items="proofOfAddressList"
                      label="Proof of Address"
                      item-title="name"
                      item-value="id"
                    />
                  </VCol>
                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.proofId"
                      :items="proofIdList"
                      label="Proof of ID"
                      item-title="name"
                      item-value="id"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField v-model="enviroData.refNo" label="Ref. No." />
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
            <VCard title="Location Details" class="mb-6 border">
              <VCardText>
                <VRow>
                  <VCol md="6" cols="12">
                    <VSelect
                      v-model="enviroData.prefix"
                      :items="prefixList"
                      label="Prefix"
                      item-title="name"
                      item-value="id"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VSelect
                      v-model="enviroData.location"
                      :items="locationList"
                      label="Location"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VSelect
                      v-model="enviroData.action"
                      :items="actionList"
                      label="Action"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                    />
                  </VCol>

                  <VCol md="6" cols="12">
                    <AppDateTimePicker
                      v-model="enviroData.caution"
                      label="Caution"
                      :config="{
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: 'H:i',
                      }"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <AppDateTimePicker
                      v-model="enviroData.secondCaution"
                      label="2nd Caution"
                      :config="{
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: 'H:i',
                      }"
                    />
                  </VCol>
                  <VCol cols="12" md="6">
                    <VLabel class="mb-2"> Offender Reply </VLabel>
                    <VRadioGroup v-model="enviroData.offenderReply" inline>
                      <VRadio label="Yes" value="yes" />
                      <VRadio label="No" value="no" />
                    </VRadioGroup>
                  </VCol>

                  <VCol md="6" cols="12">
                    <VTextarea
                      v-model="enviroData.description"
                      label="Description"
                      auto-grow
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextarea
                      v-model="enviroData.descriptionOfWaste"
                      label="Description of Waste"
                      auto-grow
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="enviroData.offenceLocation"
                      label="Offence Location"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.typeOfLand"
                      :items="typeOfLandList"
                      label="Type Of Land"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                  /></VCol>
                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.townArea"
                                       label="Town/Local Area"
                      :items="townAreaList"
                      item-value="id"
                      item-title="name"
                      
                  /></VCol>

                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.POIprefix"
                      :items="POIprefixList"
                      label="POI Prefix"
                      item-title="name"
                      item-value="id"
                  /></VCol>

                  <VCol md="6" cols="12">
                    <VTextField v-model="enviroData.POI" label="POI" />
                  </VCol>

                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.visibility"
                      :items="visibilityList"
                      label="Visibility"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                  /></VCol>
                  <VCol cols="12" md="6">
                    <VSelect
                      v-model="enviroData.weather"
                      :items="weatherList"
                      label="Weather"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                  /></VCol>
                  <VCol md="6" cols="12">
                    <AppDateTimePicker
                      v-model="enviroData.offenceDateTime"
                      label="Offence Date and Time"
                      :config="{ enableTime: true, dateFormat: 'Y-m-d H:i' }"
                      :rules="[requiredValidator]"
                      @update:modelValue="validateDates"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <AppDateTimePicker
                      v-model="enviroData.issueDateTime"
                      label="Issue Date and Time"
                      :config="{ enableTime: true, dateFormat: 'Y-m-d H:i' }"
                      :rules="[requiredValidator]"
                      @update:modelValue="validateDates"
                    />
                    <small style="color:red" v-if="dateError">*Issue date should be greater than offence date</small> 
                  </VCol>
                  <VCol md="6" cols="12">
                    <VLabel class="mb-2"> Enviro. Issued on the spot ? </VLabel>
                    <VCheckbox v-model="enviroData.enviroIssueOnSpot" />
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
            <VCard title="Witness Details" class="mb-6 border">
              <VCardText>
                <VRow>
                  <VCol cols="12" md="6">
                    <VLabel class="mb-2"> Is Witness Available ? </VLabel>
                    <VRadioGroup v-model="enviroData.isWitnessAvailable" inline>
                      <VRadio label="Yes" value="yes" />
                      <VRadio label="No" value="no" />
                    </VRadioGroup>
                  </VCol>

                  <VCol md="6" cols="12">
                    <VTextarea
                      v-model="enviroData.officerStatement"
                      label="Officer Statement"
                      auto-grow
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
          @click="refEnviroAddForm?.validate()"
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
