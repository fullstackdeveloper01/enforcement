<script lang="ts" setup>
import { siteStore } from '@/pages/setup/sites/siteStore';
import type { SiteProperties } from '@/pages/setup/sites/types';
import { requiredValidator } from "@validators";
import axios from 'axios';
import { VForm } from "vuetify/components";

const sitesStore = siteStore()
const loadings = ref<boolean[]>([]);
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const slugError = ref(false)
const showColorPicker = ref(false);

const siteData = ref({
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
    country: 'United Kingdom',
    geo_color: "#ffffff",
    region_id: null, 
    logo: null,
    showColorPicker: false
});

const logoFile = ref(false);
const tab = ref("employee-details");
const roleList = ref([]);


const refAddForm = ref<VForm>();

// 👉 Add new user
const addSite = (siteData: SiteProperties) => {
    loadings.value[0] = true;
    sitesStore.createSite(siteData).then(response => {
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

const onSubmit = () => {
    refAddForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid) addSite(siteData.value);
  }); 
};

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

const handleFileUpload = (event: any) => {
  siteData.value.logo = event.target.files[0];
  logoFile.value = URL.createObjectURL(event.target.files[0])
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

</script>
<template>
  <VCard title="Add Site" class="mb-6">
    
    <VForm class="mt-2" ref="refAddForm" @submit.prevent="onSubmit" enctype="multipart/form-data">
      <VCardText>
        <VWindow class="py-2" v-model="tab">
          <VWindowItem value="employee-details">
            
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
                        <vFileInput @change="handleFileUpload" label="Choose Logo"></vFileInput>
                    </div>
                    <img :src="logoFile" v-if="logoFile" style="width:120px;margin-top:10px" />
                  </VCol>

                  <VCol md="6" cols="12">
                    <div id="colorPicker">
                        <v-text-field v-model="siteData.geo_color" label="Site Geo Colour" prepend-icon="mdi-format-color-fill" @click="toggleColorPicker"  />
                        <v-color-picker v-model="siteData.geo_color" v-if="showColorPicker"></v-color-picker>
                    </div>
                  </VCol>
                </VRow>
              
            
          </VWindowItem>
        </VWindow>
      </VCardText>

      <VDivider />

      <VCardText class="d-flex gap-4">
        <VBtn
          :loading="loadings[0]"
          :disabled="loadings[0]"
          type="submit"
          @click="refAddForm?.validate()"
          >Save</VBtn
        >
        <a href="/setup/sites">
            <VBtn
            type="button"
            color="secondary"
            variant="tonal"
            >Go Back</VBtn
            >
        </a>
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
<style lang="scss">
.hidden{
  display: none;
}
</style>