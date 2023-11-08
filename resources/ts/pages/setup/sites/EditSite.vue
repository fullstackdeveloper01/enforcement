<script lang="ts" setup>
import { siteStore } from '@/pages/setup/sites/siteStore';
import type { SiteProperties } from '@/pages/setup/sites/types';
import axios from '@axios';
import { VForm } from "vuetify/components";

const sitesStore = siteStore()
const route = useRoute()
const loadings = ref<boolean[]>([]);
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const slugError = ref(false)
const showColorPicker = ref(false);
const checkAll = ref(false)
const checkAll2 = ref(false)
const uploadLogo = ref(false);
const uploadedFile = ref(false);
const isAreaDeleteModalOpen = ref(false);
const isZoneDeleteModalOpen = ref(false);

const offenceSelectedRow = ref(null);
const showOffenceEditModal = ref(false)
const showOffenceDeleteModal = ref(false)

const updateOffence = ref({
    id: null,
    charge_amount_reduced: null,
    charge_days_reduced: null,
    charge_amount_full: null,
    charge_days_full: null,
    court_fees: null,
    max_fine: null,
});

const deleteAreaId = ref(null);
const deleteOffenceId = ref(null);
const deleteZoneId = ref(null);

const siteData = ref({
    id:route.params.id,
    name: null,
    slug: null,
    geographical_area_id: null,
    address_line1: null,
    address_line2: null,
    address_line3: null,
    address_line4: null,
    district: null,
    town: null,
    postal_code: null,
    county: null,
    country: null,
    geo_color: "#ffffff",
    region_id: null,
    logo: null,
    showColorPicker: false,
    current_logo: null,
    notice_charge_amount_reduced: 0,
    notice_charge_days_reduced: 0,
    notice_charge_amount_full: 0,
    notice_charge_days_full: 0,
    default_extension_days: 0,
    gdpr_url_expiry_hours: 0
});

const zones = ref([]);
const zoneData = ref({
    site_id: route.params.id,
    name: null,
    address_line1: null,    
    address_line2: null,    
    post_code: null,    
    town: null,    
    is_hotspot: false,    
});

const areas = ref([]);
const areaList = ref({
    site_id: route.params.id,
    name: null,
    zone_list: []
});

const areaUpdate = ref({
    site_id: route.params.id,
    id: null,
    name: null,    
    zones: []
});

const zoneUpdate = ref({
    id: null,
    name: null,
    town: null,
    address_line1: null,
    address_line2: null,
    post_code: null,
    is_hotspot: null
});

const siteOffences = ref([]);

const showUpdateAreaForm = ref(false);
const showCreateAreaForm = ref(true);
const showUpdateZoneForm = ref(false);
const showCreateZoneForm = ref(true);

const tab = ref("employee-details");
const roleList = ref([]);


const refUpdateForm = ref<VForm>();
const refUpdateZoneForm = ref<VForm>();
const refUpdateZonezForm = ref<VForm>();
const refEnviroForm = ref<VForm>();
const refUpdateAreaForm = ref<VForm>();
const refChangeAreaForm = ref<VForm>();
const refUpdateOffenceForm = ref<VForm>();
const zoneTable = ref();

sitesStore.fetchSite(Number(route.params.id)).then(response => {
    let res = response.data.data;

    siteData.value = {
        id:route.params.id,
        name: res.name,
        slug: res.slug,
        geographical_area_id: res.geographical_area,
        address_line1: res.address_line1,
        address_line2: res.address_line2,
        address_line3: res.address_line3,
        address_line4: res.address_line4,
        district: res.district,
        town: res.town,
        postal_code: res.postal_code,
        county: res.county,
        country: res.country,
        geo_color: res.geo_color,
        region_id: res.region_id,
        logo: null,
        current_logo: res.logo,
        showColorPicker: false,
        notice_charge_amount_reduced: res.notice_charge_amount_reduced,
        notice_charge_days_reduced: res.notice_charge_days_reduced,
        notice_charge_amount_full: res.notice_charge_amount_full,
        notice_charge_days_full: res.notice_charge_days_full,
        default_extension_days: res.default_extension_days,
        gdpr_url_expiry_hours: res.gdpr_url_expiry_hours
    }
}).catch(error => {
  console.log(error)
})

// 👉 Add new user
const updateSite = (siteData: SiteProperties) => {
    loadings.value[0] = true;
    sitesStore.update(siteData).then(response => {
    loadings.value[0] = false;
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    alertMessage.value=error.response.data.message
    alertType.value='error'
    isAlertVisible.value=true
    loadings.value[0] = false;
    console.error(error)
  })
}

const createZone = (zoneData) => {
    loadings.value[0] = true;
    
    sitesStore.createZone(zoneData).then(response => {
    loadings.value[0] = false;
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    fetchZones();
  }).catch(error => {
    alertMessage.value=error.response.data.message
    alertType.value='error'
    isAlertVisible.value=true
    loadings.value[0] = false;
    console.error(error)
  })
}

const updateEnviroTab = (siteData: SiteProperties) => {
    loadings.value[0] = true;
    sitesStore.updateEnviro(siteData).then(response => {
    loadings.value[0] = false;
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true

    fetchOffences();
    
  }).catch(error => {
    alertMessage.value=error.response.data.message
    alertType.value='error'
    isAlertVisible.value=true
    loadings.value[0] = false;
    console.error(error)
  })
}

const addAreas = (areaList) => {
    loadings.value[0] = true;
    sitesStore.addArea(areaList).then(response => {
    loadings.value[0] = false;
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true

    fetchAreas();

  }).catch(error => {
    alertMessage.value=error.response.data.message
    alertType.value='error'
    isAlertVisible.value=true
    loadings.value[0] = false;
    console.error(error)
  })
}

const udpateAreas = (udpateAreas) => {
    loadings.value[0] = true;
    sitesStore.updateArea(udpateAreas).then(response => {
    loadings.value[0] = false;
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true

  }).catch(error => {
    alertMessage.value=error.response.data.message
    alertType.value='error'
    isAlertVisible.value=true
    loadings.value[0] = false;
    console.error(error)
  })
}

const udpateOffence = (updateOffenceData) => {
    loadings.value[0] = true;
    sitesStore.updateOffence(updateOffenceData).then(response => {
    loadings.value[0] = false;
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true

  }).catch(error => {
    alertMessage.value=error.response.data.message
    alertType.value='error'
    isAlertVisible.value=true
    loadings.value[0] = false;
    console.error(error)
  })
}

const fetchZones = async() => {
    let res = await axios.get(`/api/zones/${Number(route.params.id)}`);
    let response = await res.data;
    zones.value = response;
}

const fetchAreas = async() => {
    let res = await axios.get(`/api/sites/${Number(route.params.id)}/areas`);
    let response = await res.data;
    areas.value = response.data;
}

const updateZone = (updateZone) => {
    loadings.value[0] = true;
    sitesStore.updateZone(updateZone).then(response => {
    loadings.value[0] = false;
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true

    fetchZones();
    resetZoneForm();

  }).catch(error => {
    alertMessage.value=error.response.data.message
    alertType.value='error'
    isAlertVisible.value=true
    loadings.value[0] = false;
    console.error(error)
  })
}

const fetchOffences = async() => {
    let res = await axios.get(`/api/sites/${Number(route.params.id)}/offences`);
    let response = await res.data;
    console.log(response)
    siteOffences.value = response.data;
}

onMounted(async()=>{
    await fetchZones();
    await fetchAreas();
    await fetchOffences();
})

const onSubmit = () => {
  refUpdateForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid){
        updateSite(siteData.value)
    }else{
        
    }
  }); 
};

const onUpdateZoneForm = () => {
    refUpdateZonezForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid){
        updateZone(zoneUpdate.value)
    }else{
        
    }
  }); 
}


const onSubmitZone = () => {
    refUpdateZoneForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid){
        createZone(zoneData.value)
    }else{
        
    }
  }); 
}

const onSubmitEnviro = () => {
    refEnviroForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid){
        updateEnviroTab(siteData.value)
    }else{
        
    }
  }); 
}

const onSubmitArea = () => {
    refUpdateAreaForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid){
        addAreas(areaList.value)
    }else{
        
    }
  }); 
}

const onUpdateArea = () => {
    refChangeAreaForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid){
        udpateAreas(areaUpdate.value)
        fetchAreas();
    }else{
        
    }
  }); 
}

const updateOffenceSubmit = () => {
    console.log('submitted')
    refUpdateOffenceForm.value?.validate().then(({ valid: isValid }) => {
        if (isValid){
            udpateOffence(updateOffence.value)
            fetchOffences();
        }else{
            
        }
    }); 
}

const deleteArea = () => {
    loadings.value[0] = true;
    sitesStore.deleteArea(deleteAreaId.value).then(response => {
        loadings.value[0] = false;
        alertMessage.value=response.data.message
        alertType.value='success'
        isAlertVisible.value=true
        
        fetchAreas();
        closeDeleteModal();

    });
}

const deleteZone = () => {
    loadings.value[0] = true;
    sitesStore.deleteZone(deleteZoneId.value).then(response => {
        loadings.value[0] = false;
        alertMessage.value=response.data.message
        alertType.value='success'
        isAlertVisible.value=true
        
        fetchZones();
        closeDeleteModal();
        resetZoneForm();

    });
}


const handleFileUpload = (event: any) => {
    uploadLogo.value = true;
    siteData.value.current_logo = null;
    siteData.value.logo = event.target.files[0];
    uploadedFile.value = URL.createObjectURL(event.target.files[0]);
}

const checkSlug = async(val: any) => {
 
 if(val.length > 3)
 {
   const res = await axios.post('/api/site/slug/check', {
     slug: val
   });
   const response = await res.data;
   if(response.found)
   {
     slugError.value = true;
   }else{
     slugError.value = false;
   }
 }

}

// Dummy Values
const geographical_areas = [
  { name: "North", id: "North" },
  { name: "South", id: 'South' },
  { name: "South Wales", id: 'South Wales' },
  { name: "North Wales", id: 'North Wales' },
];

const countries = [
  { name: "United Kingdom", id: "United Kingdom" },
  { name: "United States", id: "United States" },
  { name: "India", id: "India" },
  { name: "Pakistan", id: 'Pakistan' },
];

const regions = [
  { name: "North Wales", id: "North Wales" },
  { name: "South Wales", id: "South Wales" },
];

const toggleColorPicker = ()=>{
  if(showColorPicker.value == true)
  {
    showColorPicker.value = false
  }else{
    showColorPicker.value = true
  }
}

const toggleAllZones = () => {
    if (checkAll.value) {
        areaList.value.zone_list = zones.value.map((zone) => zone.id);
    } else {
        areaList.value.zone_list = [];
    }
}

const toggleAllZones2 = () => {
    if (checkAll2.value) {
        areaUpdate.value.zones = zones.value.map((zone) => zone.id);
    } else {
        areaUpdate.value.zones = [];
    }
}

const editArea = (id, name, zoness) => {
    areaUpdate.value.id = id;
    areaUpdate.value.name = name;
    var towns = [];
    if(zoness.length > 0)
    {
        for(var i=0;i<zoness.length;i++)
        {
            let zone_id = parseInt(zoness[i]);
            towns.push(zone_id);
        }
    }

    areaUpdate.value.zones = towns;

    showUpdateAreaForm.value = true;
    showCreateAreaForm.value = false;
}

const resetAreaForm = () => {
    
    areaList.value.name = null;
    areaList.value.zone_list = [];
    checkAll.value = false;

    showUpdateAreaForm.value = false;
    showCreateAreaForm.value = true;
}

const openDeleteAreaModal = (id) => {
    deleteAreaId.value = id;
    isAreaDeleteModalOpen.value = true;
}
const closeDeleteModal = () => {
    deleteAreaId.value = null;
    isAreaDeleteModalOpen.value = false; 
    isZoneDeleteModalOpen.value = false; 
}

const editOffenceModal = (index) => {
    let data = siteOffences.value[index];
    updateOffence.value = {
        id: data.id,
        charge_amount_reduced: data.charge_amount_reduced,
        charge_days_reduced: data.charge_days_reduced,
        charge_amount_full: data.charge_amount_full,
        charge_days_full: data.charge_days_full,
        court_fees: data.court_fees,
        max_fine: data.max_fine,
    }

    showOffenceEditModal.value = true;
}

const closeOffenceEditModal = ()=> {
    showOffenceEditModal.value = false;
    showOffenceDeleteModal.value = false;
}

const deleteOffenceModal = (id) => {
    deleteOffenceId.value = id;
    showOffenceDeleteModal.value = true;
}

const deleteOffence = () => {
    loadings.value[0] = true;
    sitesStore.deleteOffence(deleteOffenceId.value).then(response => {
    loadings.value[0] = false;
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true

    fetchOffences();
    closeOffenceEditModal();

  }).catch(error => {
    alertMessage.value=error.response.data.message
    alertType.value='error'
    isAlertVisible.value=true
    loadings.value[0] = false;
    console.error(error)
  })
}

const showEditZoneForm = (id, name, town, address_line1, address_line2, post_code, is_hotspot) => {

    zoneUpdate.value.id = id;
    zoneUpdate.value.name = name;
    zoneUpdate.value.town = town;
    zoneUpdate.value.address_line1 = address_line1;
    zoneUpdate.value.address_line2 = address_line2;
    zoneUpdate.value.post_code = post_code;
    zoneUpdate.value.is_hotspot = (is_hotspot == 1) ? true :false ;

    showUpdateZoneForm.value = true;
    showCreateZoneForm.value = false;

}   

const resetZoneForm = () => {
    showUpdateZoneForm.value = false;
    showCreateZoneForm.value = true;
}

const showDeleteZoneModel = (id) => {
    deleteZoneId.value = id;
    isZoneDeleteModalOpen.value = true;
}
const detectStatus = (status) => {
    if(status == true)
    {
        return true;
    }else{
        return false;
    }
}

const handleOffenceStatusToggle = async (id, status) => {
    await axios.post('/api/sites/offences/'+id+'/status',{
        
    }).then(response => {
        alertMessage.value=response.data.message
        alertType.value='success'
        isAlertVisible.value=true
  }).catch(error => {
        alertMessage.value=error.response.data.message
        alertType.value='error'
        isAlertVisible.value=true
        console.error(error)
  })
}
</script>

<template>
  <VCard title="Edit Site" class="mb-6">
    
    <div style="background:#f3f3f3;" class="d-flex jsutify-content-center">
        <VTabs v-model="tab">
            <VTab value="site-info"> Site Info </VTab>
            <VTab value="zone"> Zone/Ward </VTab>
            <VTab value="town-area"> Town/Local Area </VTab>
            <VTab value="enviro-details"> Enviro. Details </VTab>
            <VTab value="site-offences"> Site Offences </VTab>
        </VTabs>
    </div>

    <VCardText>
    <VWindow class="py-2" v-model="tab">
        <VWindowItem value="site-info">
        
            <VForm class="mt-2" ref="refUpdateForm" @submit.prevent="onSubmit">
                <VRow>
                    
                    <VCol md="12" cols="12">
                    <VTextField
                        v-model="siteData.name"
                        label="Name"
                        :rules="[requiredValidator]"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                        <VTextField
                        v-model="siteData.slug"
                        label="Unique Slug"
                        :rules="[requiredValidator]"
                        @update:modelValue="checkSlug"
                        />
                        <small id="slugError" class="error" v-if="slugError" style="color:red" >
                        *This slug is not available!
                        </small>
                    </VCol>
                    <VCol md="6" cols="12">
                    <VSelect
                        v-model="siteData.geographical_area_id"
                        :items="geographical_areas"
                        label="Geographical Area"
                        item-title="name"
                        item-value="id"
                        :rules="[requiredValidator]"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        v-model="siteData.address_line1"
                        label="Site Address"
                        :rules="[requiredValidator]"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        v-model="siteData.address_line2"
                        label="Address 2"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        v-model="siteData.address_line3"
                        label="Address 3"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        v-model="siteData.address_line4"
                        label="Address 4"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        v-model="siteData.district"
                        label="District"
                        :rules="[requiredValidator]"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        v-model="siteData.town"
                        label="Town"
                        :rules="[requiredValidator]"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        v-model="siteData.postal_code"
                        label="Postal Code"
                        :rules="[requiredValidator]"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        v-model="siteData.county"
                        label="County"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VSelect
                        v-model="siteData.country"
                        :items="countries"
                        label="Country"
                        item-title="name"
                        item-value="id"
                        :rules="[requiredValidator]"
                    />
                    </VCol>
                    <!-- <VCol md="6" cols="12">
                    <div>
                        <v-text-field v-model="siteData.geo_color" label="Site Geo Colour" prepend-icon="mdi-format-color-fill" @click="siteData.showColorPicker = true" readonly />
                        <v-menu v-model="siteData.showColorPicker" offset-y>
                            <v-color-picker v-model="siteData.geo_color" @input="siteData.showColorPicker = false" />
                        </v-menu>
                    </div>
                    </VCol> -->
                    <VCol md="6" cols="12">
                    <VSelect
                        v-model="siteData.region_id"
                        :items="regions"
                        label="Region"
                        item-title="name"
                        item-value="id"
                        :rules="[requiredValidator]"
                    />
                    </VCol>

                    <VCol md="6" cols="12">
                        <div id="colorPicker">
                            <vFileInput @change="handleFileUpload" label="Choose File"></vFileInput>
                        </div>
                        <img :src="`/uploads/sites/logos/`+siteData.current_logo" v-if="siteData.current_logo != null" width="100" style="margin-top:10px;"/>
                        <img :src="uploadedFile" v-if="uploadLogo" width="100" style="margin-top:10px;"/>
                    </VCol>

                    <VCol md="6" cols="12">
                        <div id="colorPicker">
                            <v-text-field v-model="siteData.geo_color" label="Site Geo Colour" prepend-icon="mdi-format-color-fill" @click="toggleColorPicker" />
                            <v-color-picker v-model="siteData.geo_color" v-if="showColorPicker"></v-color-picker>
                        </div>
                    </VCol>
                    
                </VRow>
                <VCardText class="d-flex gap-4 px-0">
                    <VBtn
                        :loading="loadings[0]"
                        :disabled="loadings[0]"
                        type="submit"
                        @click="refUpdateForm?.validate()"
                    >Save</VBtn
                    >
                    <a href="/setup/sites">
                        <VBtn type="button" color="secondary" variant="tonal">
                        Go Back
                        </VBtn>
                    </a>
                </VCardText>
            </VForm>
            
        </VWindowItem>

        <VWindowItem value="zone">
            <VForm class="mt-2" ref="refUpdateZoneForm" @submit.prevent="onSubmitZone" v-if="showCreateZoneForm">
                <VRow>
                    
                    <VCol md="6" cols="12">
                    <VTextField
                        label="Zone Name"
                        v-model="zoneData.name"
                        :rules="[requiredValidator]"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        label="Town"
                        v-model="zoneData.town"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        label="Address 1"
                        v-model="zoneData.address_line1"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        label="Address 2"
                        v-model="zoneData.address_line2"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        label="Postcode"
                        v-model="zoneData.post_code"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VCheckbox
                        label="Is Hotspot?"
                        v-model="zoneData.is_hotspot"
                    />
                    </VCol>
                    
                </VRow>
                <VCardText class="d-flex gap-4 px-0">
                    <VBtn
                    :loading="loadings[0]"
                    :disabled="loadings[0]"
                    type="submit"
                    @click="refUpdateForm?.validate()"
                    >Save</VBtn
                    >
                    <a href="/setup/sites">
                        <VBtn type="button" color="secondary" variant="tonal">
                        Go Back
                        </VBtn>
                    </a>
                </VCardText>
            </VForm>

            <VForm class="mt-2" ref="refUpdateZonezForm" @submit.prevent="onUpdateZoneForm" v-if="showUpdateZoneForm">
                <VRow>
                    
                    <VCol md="6" cols="12">
                    <VTextField
                        label="Zone Name"
                        v-model="zoneUpdate.name"
                        :rules="[requiredValidator]"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        label="Town"
                        v-model="zoneUpdate.town"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        label="Address 1"
                        v-model="zoneUpdate.address_line1"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        label="Address 2"
                        v-model="zoneUpdate.address_line2"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VTextField
                        label="Postcode"
                        v-model="zoneUpdate.post_code"
                    />
                    </VCol>
                    <VCol md="6" cols="12">
                    <VCheckbox
                        label="Is Hotspot?"
                        v-model="zoneUpdate.is_hotspot"
                    />
                    </VCol>
                    
                </VRow>
                <VCardText class="d-flex gap-4 px-0">
                    <VBtn
                    :loading="loadings[0]"
                    :disabled="loadings[0]"
                    type="submit"
                    @click="refUpdateZonezForm?.validate()"
                    >Update</VBtn
                    >
                
                    <VBtn type="button" color="secondary" variant="tonal" @click="resetZoneForm">
                        Reset
                    </VBtn>
                    
                </VCardText>
            </VForm>
            <hr style="border:none;border-bottom:1px solid #e9e9e9"/>

            <VRow class="px-0 pt-5">
                <VCol md="6" cols="6" class="px-0">
                    <div class="v-card-title">Zone(s) List</div>
                </VCol>
                <VCol md="6" cols="6">
                    <div class="d-flex gap-2 justify-content-right">
                        <VBtn type="button" color="info" class="v-btn--size-small">Save Order</VBtn>
                        <VBtn type="button" color="secondary" class="v-btn--size-small">Print</VBtn>
                        <VBtn type="button" color="info" class="v-btn--size-small">PDF</VBtn>
                        <VBtn type="button" color="warning" class="v-btn--size-small">Excel</VBtn>
                    </div>
                </VCol>
            </VRow>

            <VTable class="text-no-wrap table-header-bg rounded-0" ref="zoneTable">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Zone Name</th>
                        <th scope="col">Manage Geofencing</th>
                        <th scope="col">Active</th>
                        <th scope="col">Is Hotspot?</th>
                        <th scope="col">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="zone in zones" v-bind:key="zone.id" v-if="zones.length > 0">
                        <td>{{ zone.id }}</td>
                        <td>{{ zone.name }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <VBtn type="button" color="info" class="v-btn--size-small" >Edit</VBtn>
                                <VBtn type="button" color="info" class="v-btn--size-small">Import Zone</VBtn>
                            </div>
                        </td>
                        <td>
                            <VIcon icon="mdi-check" style="color:green" size="24" v-if="zone.status == 1"/>
                            <VIcon icon="mdi-close" style="color:red" size="24" v-else/>
                        </td>
                        <td>
                            <span style="color:green;" v-if="zone.is_hotspot == 1">Yes</span>
                            <span style="color:red;" v-else>No</span>
                        </td>
                        <td>
                            <VIcon icon="mdi-circle-edit-outline" class="mx-2" size="24" @click="showEditZoneForm(zone.id, zone.name, zone.town, zone.address_line1, zone.address_line2, zone.post_code, zone.is_hotspot)"/>
                            <VIcon icon="mdi-trash-outline" size="24" @click="showDeleteZoneModel(zone.id)"/>
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="7" class="text-center">No records found</td>
                    </tr>
                </tbody>
            </VTable>

        </VWindowItem>

        <VWindowItem value="town-area">
        
        <VRow>
            <VCol md="6" cols="6">
                <VForm ref="refUpdateAreaForm" v-if="showCreateAreaForm" id="addAreaForm" @submit.prevent="onSubmitArea">
                    <VRow>
                        <VCol md="12" cols="12">
                            <VTextField
                                v-model="areaList.name"
                                label="Area Name"
                                :rules="[requiredValidator]"
                            />
                        </VCol>
                        <VCol md="12" cols="12">
                            <h4 class="pb-2">
                                Select zones below
                            </h4>
                            <VTable
                                    fixed-header
                                    max-height="240px"
                                    class="elevation-2"
                                >
                                <thead>
                                    <tr>
                                        <th style="width:50px">
                                            <v-checkbox v-model="checkAll" @change="toggleAllZones"></v-checkbox>
                                        </th>
                                        <th style="font-size:16px">Zone Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="zone in zones" :key="zone.id" v-if="zones.length > 0">
                                        <td>
                                            <v-checkbox v-model="areaList.zone_list" :value="zone.id"></v-checkbox>
                                        </td>
                                        <td>{{zone.name}}</td>
                                    </tr>
                                    <tr v-else>
                                        <td colspan="2" class="text-center">
                                            No records found
                                        </td>
                                    </tr>
                                </tbody>
                            </VTable>
                        </VCol>
                    </VRow>

                    <VCardText class="d-flex gap-4 px-0">
                        <VBtn
                            :loading="loadings[0]"
                            :disabled="loadings[0]"
                            type="submit"
                            @click="refUpdateAreaForm?.validate()"
                            >Add</VBtn
                        >
                        <a href="/setup/sites">
                            <VBtn type="button" color="secondary" variant="tonal">
                            Go Back
                            </VBtn>
                        </a>
                    </VCardText>
                </VForm>

                <VForm ref="refChangeAreaForm" v-if="showUpdateAreaForm" id="updateAreaForm" @submit.prevent="onUpdateArea">
                    <VRow>
                        <VCol md="12" cols="12">
                            <VTextField
                                v-model="areaUpdate.name"
                                label="Area Name"
                                :rules="[requiredValidator]"
                            />
                        </VCol>
                        <VCol md="12" cols="12">
                            <h4 class="pb-2">
                                Select zones below
                            </h4>
                            <VTable
                                    fixed-header
                                    max-height="240px"
                                    class="elevation-2"
                                >
                                <thead>
                                    <tr>
                                        <th style="width:50px">
                                            <v-checkbox v-model="checkAll2" @change="toggleAllZones2"></v-checkbox>
                                        </th>
                                        <th style="font-size:16px">Zone Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="zone in zones" :key="zone.id">
                                        <td>
                                            <v-checkbox v-model="areaUpdate.zones" :value="zone.id" :checked="areaUpdate.zones.includes(zone.id)"></v-checkbox>
                                        </td>
                                        <td>{{zone.name}}</td>
                                    </tr>
                                </tbody>
                            </VTable>
                        </VCol>
                    </VRow>

                    <VCardText class="d-flex gap-4 px-0">
                        <VBtn
                            :loading="loadings[0]"
                            :disabled="loadings[0]"
                            type="submit"
                            @click="refChangeAreaForm?.validate()"
                            >Update</VBtn
                        >
                        <VBtn type="button" color="secondary" variant="tonal" @click="resetAreaForm">
                            Reset
                        </VBtn>
                    </VCardText>
                </VForm>
            </VCol>

            <VCol md="6" cols="6">
                <h4 style="margin-bottom:15px">Local Area(s) List</h4>
                <VTable fixed-header max-height="240px" class="elevation-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Area Name</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(area, index) in areas" v-bind:key="area.id" v-if="areas.length > 0">
                            <td>{{ index + 1 }}</td>
                            <td>{{ area.name }}</td>
                            <td style="text-align:right;">
                                <v-icon class="mx-2" @click="editArea(area.id, area.name, area.zones)">mdi-pencil</v-icon>
                                <v-icon @click="openDeleteAreaModal(area.id)">mdi-trash</v-icon>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="3" class="text-center">
                                No records found
                            </td>
                        </tr>
                    </tbody>
                </VTable>
            </VCol>
        </VRow>
        
        </VWindowItem>

        <VWindowItem value="enviro-details">
            <VForm class="mt-2" ref="refEnviroForm" @submit.prevent="onSubmitEnviro">
                <VRow>
                    <VCol md="12" cols="12">
                        <h4>
                            Fixed Penalty Notice (gross):
                            <span style="color:red">*</span>
                        </h4>
                    </VCol>
                    <VCol md="6" cols="6">
                        <VTextField
                            v-model="siteData.notice_charge_amount_reduced"
                            label="Amount (If paid in)"
                            :rules="[requiredValidator]"
                        />
                    </VCol>
                    <VCol md="6" cols="6">
                        <VTextField
                            v-model="siteData.notice_charge_days_reduced"
                            label="Days (Reduced)"
                            :rules="[requiredValidator]"
                        />
                    </VCol>

                    <VCol md="6" cols="6">
                        <VTextField
                            v-model="siteData.notice_charge_amount_full"
                            label="Amount (If paid in)"
                            :rules="[requiredValidator]"
                        />
                    </VCol>
                    <VCol md="6" cols="6">
                        <VTextField
                            v-model="siteData.notice_charge_days_full"
                            label="Days (Full)"
                            :rules="[requiredValidator]"
                        />
                    </VCol>
                    <VCol md="12" cols="12"><hr style="border:none;border-top:1px solid #e9e9e9"/></VCol>
                    <VCol md="6" cols="6">
                        <VTextField
                            v-model="siteData.default_extension_days"
                            label="Default Extension Days"
                            :rules="[requiredValidator]"
                        />
                    </VCol>
                    <VCol md="6" cols="6">
                        <VTextField
                            v-model="siteData.gdpr_url_expiry_hours"
                            label="GDPR URL Expiry Hours"
                            :rules="[requiredValidator]"
                        />
                    </VCol>
                </VRow>
                <VCardText class="d-flex gap-4 px-0">
                    <VBtn
                    :loading="loadings[0]"
                    :disabled="loadings[0]"
                    type="submit"
                    @click="refEnviroForm?.validate()"
                    >Save</VBtn
                    >
                    <a href="/setup/sites">
                        <VBtn type="button" color="secondary" variant="tonal">
                        Go Back
                        </VBtn>
                    </a>
                </VCardText>
            </VForm>
        </VWindowItem>

        <VWindowItem value="site-offences">

            <VRow>
                <VCol md="12" cols="12">
                    <h4>Site Offence List</h4>
                </VCol>
                <VCol md="12" cols="12">

                    <VTable fixed-header class="elevation-3">
                        <thead>
                            <tr>
                                <th>Offence Details</th>
                                <th>Active Charges</th>
                                <th>Court Fees</th>
                                <th>Active</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="siteOffences.length > 0" v-for="(obj, index) in siteOffences">
                                <td style="padding-top:5px">
                                    <p>
                                        {{ obj.offence.name }}
                                    </p>
                                    <p style="margin-top:-12px">
                                        <b>Group:</b> {{ obj.offence_group.englishName }}
                                    </p>
                                </td>
                                <td style="padding-top:5px">
                                    <p>
                                        £{{obj.charge_amount_reduced}} pounds if paid in {{ obj.charge_days_reduced }} days (Reduced)
                                    </p>
                                    <p>
                                        £{{ obj.charge_amount_full }} pounds if paid in {{ obj.charge_days_full }} days (Full)
                                    </p>
                                    <p>
                                        £{{ obj.max_fine }} Maximum fine
                                    </p>
                                </td>
                                <td style="padding-top:5px">
                                    £{{ obj.court_fees }}
                                </td>
                                <td>
                                  <v-switch :model-value="detectStatus(obj.status)" @change="handleOffenceStatusToggle(obj.id, obj.status)"></v-switch>
                                </td>
                                <td style="padding-top:5px">
                                    <v-icon class="mx-2" @click="editOffenceModal(index)">mdi-pencil</v-icon>
                                    <!-- <v-icon @click="deleteOffenceModal(obj.id)">mdi-trash</v-icon> -->
                                </td>
                            </tr>
                        </tbody>
                    </VTable>

                </VCol>
            </VRow>

        </VWindowItem>

    </VWindow>
    </VCardText>

    <VDivider />

  </VCard>

  <!-- Delete Area/Town Modal -->
  <v-dialog v-model="isAreaDeleteModalOpen" max-width="500px">
    <v-card>
        <v-card-title class="headline">Delete Confirmation</v-card-title>
        <v-card-text>
            Are you sure you want to delete?
        </v-card-text>
        <v-card-actions>
            <v-btn color="primary" @click="deleteArea">Delete</v-btn>
            <v-btn color="secondary" @click="closeDeleteModal">Cancel</v-btn>
        </v-card-actions>
    </v-card>
  </v-dialog>

  <!-- Edit Offence Modal -->
  <v-dialog v-model="showOffenceEditModal" max-width="500px">
    <v-card>
        <v-card-title class="headline">Update Offence</v-card-title>
        <v-form ref="refUpdateOffenceForm" @submit.prevent="updateOffenceSubmit">
            <v-card-text>
                <VRow>
                    <VCol md="6" cols="6">
                        <VTextField
                            v-model="updateOffence.charge_amount_reduced"
                            label="Amount"
                            :rules="[requiredValidator]"
                        />
                    </VCol>
                    <VCol md="6" cols="6">
                        <VTextField
                            v-model="updateOffence.charge_days_reduced"
                            label="Days (Reduced)"
                            :rules="[requiredValidator]"
                        />
                    </VCol>

                    <VCol md="6" cols="6">
                        <VTextField
                            v-model="updateOffence.charge_amount_full"
                            label="Amount"
                            :rules="[requiredValidator]"
                        />
                    </VCol>
                    <VCol md="6" cols="6">
                        <VTextField
                            v-model="updateOffence.charge_days_full"
                            label="Days (Full)"
                            :rules="[requiredValidator]"
                        />
                    </VCol>

                    <VCol md="6" cols="6">
                        <VTextField
                            v-model="updateOffence.max_fine"
                            label="Maximum Fine"
                            :rules="[requiredValidator]"
                        />
                    </VCol>

                    <VCol md="6" cols="6">
                        <VTextField
                            v-model="updateOffence.court_fees"
                            label="Court Fees"
                            :rules="[requiredValidator]"
                        />
                    </VCol>
                </VRow>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    :loading="loadings[0]"
                    :disabled="loadings[0]"
                    type="submit"
                    @click="refUpdateOffenceForm?.validate()"
                >Update</v-btn
                >
                <v-btn text color="secondary" @click="closeOffenceEditModal">Cancel</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
  </v-dialog>

  <!-- Delete Offence Modal -->
  <v-dialog v-model="showOffenceDeleteModal" max-width="500px">
    <v-card>
        <v-card-title class="headline">Delete Confirmation</v-card-title>
        <v-card-text>
            Are you sure you want to delete this record?
        </v-card-text>
        <v-card-actions>
            <v-btn color="primary" @click="deleteOffence">Delete</v-btn>
            <v-btn color="secondary" @click="closeOffenceEditModal">Cancel</v-btn>
        </v-card-actions>
    </v-card>
  </v-dialog>

  <!-- Delete Zone Modal -->
  <v-dialog v-model="isZoneDeleteModalOpen" max-width="500px">
    <v-card>
        <v-card-title class="headline">Delete Confirmation</v-card-title>
        <v-card-text>
            Are you sure you want to delete?
        </v-card-text>
        <v-card-actions>
            <v-btn color="primary" @click="deleteZone">Delete</v-btn>
            <v-btn color="secondary" @click="closeDeleteModal">Cancel</v-btn>
        </v-card-actions>
    </v-card>
  </v-dialog>

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

<style lang="scss">
.v-btn--size-small {
    --v-btn-size: 0.75rem!important;
    --v-btn-height: 30px!important;
    font-size: 0.75rem!important;
    min-width: 54px!important;
    padding: 0 16px!important;
}
.justify-content-right{
    justify-content: flex-end!important;
}
</style>