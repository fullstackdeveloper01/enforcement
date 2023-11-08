<script lang="ts" setup>
import { useRoleStore } from '@/pages/admin/role/RoleStore';
import { useUserListStore } from '@/pages/admin/user/useUserListStore';
import AppDateTimePicker from "@core/components/AppDateTimePicker.vue";
import { confirmedValidator, emailValidator, integerValidator, passwordValidator, requiredValidator } from "@validators";
import { VForm } from "vuetify/components";

const roleStore = useRoleStore()
const userListStore = useUserListStore()
const loadings = ref<boolean[]>([]);
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()

const userData = ref({
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


const refUserAddForm = ref<VForm>();



roleStore.listRole({
    status: '1',
  }).then(response => {
  console.log(response.data.data)
    roleList.value = response.data.data
  }).catch(error => {
    console.error(error)
  })

// 👉 Add new user
const addNewUser = (userData: UserProperties) => {
loadings.value[0] = true;
  userListStore.addUser(userData).then(response => {
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

const onSubmit = () => {
  refUserAddForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid) addNewUser(userData.value);
  }); 
};

</script>

<template>
  <VCard title="Add User" class="mb-6">
    
    <VTabs v-model="tab">
      <VTab value="employee-details"> Employee Details </VTab>
      <VTab value="user-info"> User Info. </VTab>
      <VTab value="operator-info"> Operator Info. </VTab>
    </VTabs>
    <VForm class="mt-2" ref="refUserAddForm" @submit.prevent="onSubmit">
      <VCardText>
        <VWindow class="py-2" v-model="tab">
          <VWindowItem value="employee-details">
            
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
                <VCol
                  cols="12"
                  md="6"
                >
                  <VTextField
                    v-model="userData.password"
                    type="password"
                    label="Your Password"
                    :rules="[requiredValidator, passwordValidator]"
                  
                  />
                </VCol>

      <VCol
        cols="12"
        md="6"
      >
        <VTextField
          v-model="userData.confirmPassword"
          type="password"
          label="Confirm Password"
          :rules="[requiredValidator, confirmedValidator(userData.confirmPassword, userData.password)]"
          
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
              
            
          </VWindowItem>

          <VWindowItem value="user-info"> </VWindowItem>

          <VWindowItem value="operator-info"> </VWindowItem>
        </VWindow>
      </VCardText>

      <VDivider />

      <VCardText class="d-flex gap-4">
        <VBtn
          :loading="loadings[0]"
          :disabled="loadings[0]"
          type="submit"
          @click="refUserAddForm?.validate()"
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
