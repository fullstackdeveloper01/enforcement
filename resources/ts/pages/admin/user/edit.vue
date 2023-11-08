<script lang="ts" setup>
import { useRoleStore } from '@/pages/admin/role/RoleStore';
import { useUserListStore } from '@/pages/admin/user/useUserListStore';
import axios from "@axios";
import AppDateTimePicker from "@core/components/AppDateTimePicker.vue";
import { emailValidator, integerValidator, requiredValidator } from "@validators";
import { VForm } from "vuetify/components";

const roleStore = useRoleStore()
const userListStore = useUserListStore()
const route = useRoute()
const loadings = ref<boolean[]>([]);
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const openAssignSiteModal=ref(false)
const openRemoveAssignSiteModal = ref(false);

const userData = ref({
  id:route.params.id,
  firstName: null,
  lastName:null,
  startDate:null,
  endDate:null,
  email:null,
  roleId:null,
  niNumber:null,
  password:null,
  confirmPassword:null,
  operatorNumber:null,
  pinNumber:null,
  is_officer: false
});
const tab = ref("employee-details");
const roleList = ref([]);
const sites = ref([]);
const siteList = ref([]);
const assignSiteId = ref(null);

const refUserUpdateForm = ref<VForm>();
const refAssignSiteForm = ref<VForm>();

onMounted(async () => {
  await fetchAssignedSites();
  await fetchSites();
})

userListStore.fetchUser(Number(route.params.id)).then(response => {
  userData.value = {
    id:route.params.id,
    firstName: response.data.data.first_name,
    lastName:response.data.data.last_name,
    startDate:response.data.data.start_date,
    endDate:response.data.data.end_date,
    email:response.data.data.email,
    roleId:response.data.data.role.id,
    niNumber:response.data.data.ni_number,
    password:null,
    confirmPassword:null,
    operatorNumber:response.data.data.operator_number,
    pinNumber:response.data.data.pin_number,
    is_officer:response.data.data.is_officer
  }
  console.log(userData);

}).catch(error => {
  console.log(error)
})

roleStore.listRole({
    status: '1',
  }).then(response => {
  console.log(response.data.data)
    roleList.value = response.data.data
  }).catch(error => {
    console.error(error)
})

// 👉 Add new user
const updateUser = (userData: UserProperties) => {
loadings.value[0] = true;
  userListStore.updateUser(userData).then(response => {
    loadings.value[0] = false;
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
   console.log(error);
   alertMessage.value=error.response.data.message
    alertType.value='error'
    isAlertVisible.value=true
    loadings.value[0] = false;
    console.error(error)
  })
}

// Assign New Site
const assignSite = (siteId: number) => {
  loadings.value[0] = true;
  axios.post(`/api/user/assign-site`,{
    site_id: siteId,
    user_id: route.params.id,
  })
  .then(response => {
    loadings.value[0] = false;
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true

    closeModals();
    fetchAssignedSites();
    
  }).catch(error => {
   console.log(error);
   alertMessage.value=error.response.data.message
    alertType.value='error'
    isAlertVisible.value=true
    loadings.value[0] = false;
    console.error(error)
  })
}
const onSubmit = () => {
  refUserUpdateForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid) updateUser(userData.value);
  }); 
};

const fetchAssignedSites = ()=>{
  userListStore.fetchAssignedSites(Number(route.params.id))
  .then(response => {
    console.log(response)
    if(response.data.success)
    {
      sites.value = response.data.data;
      console.log(sites.value)
    }
  }).catch(error => {
    console.log(error)
  })
}

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

const assignSiteModal = () => {
  openAssignSiteModal.value = true;
}

const removeAssignedSite = () => {
  console.log(route.params.id);
  axios.post(`/api/user/site/unlink`, {
    site_id: assignSiteId.value,
    user_id: route.params.id,
  })
  .then(response => {
    loadings.value[0] = false;
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true

    closeModals();
    fetchAssignedSites();
    
  }).catch(error => {
   console.log(error);
   alertMessage.value=error.response.data.message
    alertType.value='error'
    isAlertVisible.value=true
    loadings.value[0] = false;
    console.error(error)
  })
}

const closeModals = () => {
  openAssignSiteModal.value = false;
  openRemoveAssignSiteModal.value = false;
}

const AssignSiteSubmit = () => {
  refAssignSiteForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid) assignSite(assignSiteId.value);
  }); 
};

const removeAssignedSiteModal = (id) => {
  assignSiteId.value = id;
  openRemoveAssignSiteModal.value = true;
};

</script>

<template>
  <VCard title="Update User" class="mb-6">
    
    <VTabs v-model="tab">
      <VTab value="employee-details"> Employee Details </VTab>
      <VTab value="assigned-sites"> Sites </VTab>
      <VTab value="user-info"> User Info. </VTab>
      <VTab value="operator-info"> Operator Info. </VTab>
    </VTabs>
    
      <VCardText>
        <VWindow class="py-2" v-model="tab">
          <VWindowItem value="employee-details">
            <VForm class="mt-2" ref="refUserUpdateForm" @submit.prevent="onSubmit">
                <VRow>
                
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="userData.firstName"
                      label="First Name"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="userData.lastName"
                      label="Last Name"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <AppDateTimePicker
                      v-model="userData.startDate"
                      label="Start Date"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <AppDateTimePicker
                      v-model="userData.endDate"
                      label="End Date"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="userData.email"
                      label="Email Id"
                      :rules="[requiredValidator, emailValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VSelect
                      v-model="userData.roleId"
                      :items="roleList"
                      label="Role"
                      item-title="name"
                      item-value="id"
                    />
                  </VCol>
                  
      <VCol md="6" cols="12">
                    <VTextField
                      v-model="userData.niNumber"
                      
                      label="NI Number"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
      <VCol md="6" cols="12">
                    <VTextField
                      v-model="userData.operatorNumber"
                      label="Operator Number"
                      :rules="[requiredValidator,integerValidator]"
                    />
                  </VCol>
                  <VCol md="6" cols="12">
                    <VTextField
                      v-model="userData.pinNumber"
                      
                      label="Pin Number"
                      :rules="[requiredValidator,integerValidator]"
                    />
                  </VCol>

                  <VCol md="6" cols="12">
                    <VCheckbox
                      v-model="userData.is_officer"
                      label="Is Officer?"
                    />
                  </VCol>
                  
                </VRow>
                
                <VRow>
                  <VCol md="12" cols="12">
                    <VDivider />
                  </VCol>
                  <VCol md="12" cols="12">
                    <VCardText class="d-flex gap-4" style="padding: 0;">
                      <VBtn
                        :loading="loadings[0]"
                        :disabled="loadings[0]"
                        type="submit"
                        @click="refUserUpdateForm?.validate()"
                        >Save</VBtn
                      >
                      <VBtn color="secondary" variant="tonal">
                        Save & Refer to Prosecution
                      </VBtn>
                    </VCardText>
                  </VCol>
                </VRow>
            </VForm>
          </VWindowItem>

          <VWindowItem value="assigned-sites">
            <VRow>
              <VCol md="12" cols="12" class="d-flex justify-content-right">
                <VBtn color="primary" @click="assignSiteModal">
                  <VIcon icon="mdi-plus" /> Assign Site
                </VBtn>
              </VCol>
              <VCol md="12" cols="12">
                <VTable class="text-no-wrap table-header-bg rounded-0">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Site Name</th>
                        <th class="text-right">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-if="sites.length > 0" v-for="item in sites" v-bind:key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.site.name }}</td>
                        <td class="text-right">
                          <VIcon 
                          icon="mdi-trash"
                          :size="22"
                          @click="removeAssignedSiteModal(item.id)"
                          class="me-3" />
                        </td>
                      </tr>
                      <tr v-else>
                        <td colspan="3" class="text-center">No records found</td>
                      </tr>
                    </tbody>
                </VTable>
              </VCol>
            </VRow>
          </VWindowItem>
          
          <VWindowItem value="user-info"> </VWindowItem>

          <VWindowItem value="operator-info"> </VWindowItem>
        </VWindow>
      </VCardText>
  </VCard>

  <!-- Modals -->
  <!-- Assign Site Modal -->
  <v-dialog v-model="openAssignSiteModal" max-width="500px">
    <v-card>
        <v-card-title class="headline">Assign Site</v-card-title>
        <v-form ref="refAssignSiteForm" @submit.prevent="AssignSiteSubmit">
            <v-card-text>
              <VSelect
                v-model="assignSiteId"
                :items="siteList"
                label="Choose Site"
                item-title="name"
                item-value="id"
                :rules="[requiredValidator]"
              />
            </v-card-text>
            <v-card-actions>
                <v-btn
                    :loading="loadings[0]"
                    :disabled="loadings[0]"
                    type="submit"
                    @click="refAssignSiteForm?.validate()"
                    >Assign</v-btn
                    >
                <v-btn text color="secondary" @click="closeModals">Cancel</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
  </v-dialog>

  <!-- Remove Assigned Site Modal -->
  <v-dialog v-model="openRemoveAssignSiteModal" max-width="500px">
    <v-card>
        <v-card-title class="headline">Remove Assigned Site</v-card-title>
        <v-form ref="refAssignSiteForm" @submit.prevent="removeAssignedSite">
            <v-card-text>
              <p>
                Are you sure you want to unlink this site from user account?
              </p>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    :loading="loadings[0]"
                    :disabled="loadings[0]"
                    type="submit"
                    >Yes, Remove</v-btn
                    >
                <v-btn text color="secondary" @click="closeModals">Cancel</v-btn>
            </v-card-actions>
        </v-form>
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
