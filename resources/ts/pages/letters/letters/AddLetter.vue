<script lang="ts" setup>
import { manageStore } from '@/pages/letters/letters/manageStore';
import { requiredValidator } from "@validators";
import { VForm } from "vuetify/components";

const letterStore = manageStore()
const loadings = ref<boolean[]>([]);
const isLoading = ref(true);
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const slugError = ref(false)

const sites = ref([]);
const groups = ref([]);
const offences = ref([]);

const letterData = ref({
    name: null,
    site_id: null,
    
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
// const addSite = (letterData: SiteProperties) => {
//     loadings.value[0] = true;
//     sitesStore.createSite(letterData).then(response => {
//     loadings.value[0] = false;
//     alertMessage.value=response.data.message
//     alertType.value='success'
//     isAlertVisible.value=true
//   }).catch(error => {
//     alertMessage.value=error.response.data.message
//     alertType.value='error'
//     isAlertVisible.value=true
//     loadings.value[0] = false;
//     console.error(error)
//   })
// }

// const onSubmit = () => {
//     refAddForm.value?.validate().then(({ valid: isValid }) => {
//     if (isValid) addSite(letterData.value);
//   }); 
// };

const fetchSites = async() => {
    await letterStore.fetchSites().then(response => {
       let data = response.data.data;
       sites.value = data;
    });
}
const fetchGroups = async() => {
    await letterStore.fetchGroups().then(response => {
       let data = response.data.data;
       groups.value = data;
    });
}
const fetchOffenceGroups = async() => {
    await letterStore.fetchOffences().then(response => {
       let data = response.data;
       offences.value = data;
    });
}

onMounted(() => {
    fetchSites();
    fetchGroups();
    fetchOffenceGroups();
    isLoading.value = false;

});


</script>
<template>
  <VCard title="Add Letter" class="mb-6">
    
    <VForm class="mt-2" ref="refAddForm" enctype="multipart/form-data">
      <VCardText>
        <VWindow class="py-2" v-model="tab">
          <VWindowItem value="employee-details">
            
                <VRow>
                
                  <VCol md="12" cols="12">
                    <VSelect
                      v-model="letterData.site_id"
                      :items="sites"
                      label="Select Site"
                      item-title="name"
                      item-value="id"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="letterData.slug"
                      label="Unique Slug"
                      :rules="[requiredValidator]"
                    />
                    <small id="slugError" class="error" v-if="slugError" style="color:red" >
                      *This slug is not available!
                    </small>
                  </VCol>
                  
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="letterData.address_line1"
                      label="Site Address"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="letterData.address_line2"
                      label="Address 2"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="letterData.address_line3"
                      label="Address 3"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="letterData.address_line4"
                      label="Address 4"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="letterData.district"
                      label="District"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="letterData.town"
                      label="Town"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="letterData.postal_code"
                      label="Postal Code"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="letterData.county"
                      label="County"
                    />
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