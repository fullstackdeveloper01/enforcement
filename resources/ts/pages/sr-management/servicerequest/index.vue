<script setup lang="ts">
import AddEditEnviroDialog from '@/pages/case-management/enviro/AddEditEnviroDialog.vue';
import type { EnviroProperties } from '@/pages/case-management/enviro/types';
import { useEnviroListStore } from '@/pages/case-management/enviro/useEnviroListStore';

// 👉 Store
const enviroListStore = useEnviroListStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const dateRange = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalEnviroItems = ref(0)
const enviroItems = ref([])
const srrequests = ref([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)

// 👉 Fetching enviroitems
const fetchEnviroItems = () => {
isTableLoading.value = true
  // enviroListStore.fetchEnviroItems({
  //   q: searchQuery.value,
  //   status: selectedStatus.value,
  //   perPage: rowPerPage.value,
  //   currentPage: currentPage.value,
  // }).then(response => {
  //   enviroItems.value = response.data.data
  //   totalPage.value = response.data.last_page
  //   totalEnviroItems.value = response.data.total
  //   isTableLoading.value = false
  // }).catch(error => {
  //   console.error(error)
  // })

  // axios.get('/api/getAllService', { 
  //   q: searchQuery.value,
  //   status: selectedStatus.value,
  //   perPage: rowPerPage.value,
  //   currentPage: currentPage.value,
  //  })

  const token = localStorage.getItem('accessToken')

  var myHeaders = new Headers();
  myHeaders.append(
    "Authorization", "Bearer "+token)
  var requestOptions = {
    method: 'GET',
    headers: myHeaders,
    redirect: 'follow'
  };

   fetch(window.location.origin+"/api/getAllService", requestOptions)
  .then(response => response.json())
  .then((response) => {
    console.log('test1');
    console.log(response);
    srrequests.value = response.data
    totalPage.value = response.last_page
    totalEnviroItems.value = response.total
    isTableLoading.value = false
  })
  .catch(error => console.log('error', error));
  
}

onMounted(async () => {
  await fetchEnviroItems()
})

watchEffect(fetchEnviroItems)

// 👉 search filters

const status = [
{ title: 'All', value: '' },
 
]

const isAddEditEnviroDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = enviroItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = enviroItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalEnviroItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new enviro
const addNewEnviro = (enviroData: EnviroProperties) => {
  enviroListStore.addEnviro(enviroData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
  // refetch User
  fetchEnviroItems()
}

const updateStatusEnviro = (id:number  , status:string) => {
  enviroListStore.updateEnviroStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}
const updateEnviro = (enviroData: EnviroProperties) => {
  enviroListStore.updateEnviro(enviroData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
  // refetch User
  fetchEnviroItems()
}
const siteList = [
  {
    name: "Brentwood Borough Council",
    id: 1,
  },
  {
    name: "Canterbury City Council",
    id: 2,
  },
  {
    name: "Cyngor Bwrdeistref  Borough Council",
    id: 3,
  },
  {
    name: "Hammersmith & Fulham Council",
    id: 4,
  },
];
const fetchSiteName = (id) => {
  const site = siteList.find(site => site.id === id);
  return site ? site.name : null;
}
const officerList = [
  { name: "Ahmed Farooque", id: 1 },
  { name: "Andrew Macdonald", id: 2 },
  { name: "Bianca Cristea", id: 3 },
  { name: "Chloe Bourne", id: 4 },
];
const fetchOfficerName = (id) => {
  const site = officerList.find(site => site.id === id);
  return site ? site.name : null;
}
const offenceList = [
  { name: "Littering", id: 1 },
  { name: "PSPO", id: 2 },
  { name: "Graffiti", id: 3 },
  { name: "Fly Posting", id: 4 },
];
const fetchOffenceName = (id) => {
  const site = offenceList.find(site => site.id === id);
  return site ? site.name : null;
}
const formatDate = (dateString) => {
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' , hour: '2-digit', 
    minute: '2-digit',  });
    }
</script>

<template>
  <section>
    <VCard
      title="Search Filters"
      class="mb-6"
    >
      <VCardText>
        <VRow>
          <!-- 👉 Select Status -->
          <VCol
            cols="12"
            sm="4"
          >
            <VSelect
              v-model="selectedStatus"
              label="Select Status"
              :items="status"
            
              clear-icon="mdi-close"
            />
          </VCol>
          <VCol
            cols="12"
            sm="4"
          >
            <AppDateTimePicker
              v-model="dateRange"
              label="Issue Date"
              clear-icon="mdi-close"
              clearable
              :config="{ mode: 'range' }"
            />
          </VCol>
        </VRow>
      </VCardText>
    </VCard>

    <VCard >
      <VCardText class="d-flex flex-wrap gap-4">
       <VCardTitle class="px-0">Service Request Details </VCardTitle>
        <!-- 👉 Export button -->
      

        <VSpacer />

        <div class="app-user-search-filter d-flex align-center gap-6">
          <!-- 👉 Search  -->
          <VTextField
            v-model="searchQuery"
            placeholder="Search"
            density="compact"
          />

          <!-- 👉 Add Service Request-->
          <VBtn :to="{ name: 'add-service' }" >
            Add Service Request
          </VBtn>
        </div>
      </VCardText>

      <VDivider />
<VProgressLinear
v-if="isTableLoading"
    indeterminate
    color="primary"
  />
      <VTable class="text-no-wrap table-header-bg rounded-0 tbc">
        <!-- 👉 table head -->
        <thead>
          <tr>
            <th
              scope="col"
              style="width: 3rem;"
            >
              ID
            </th>
            <th scope="col">
              Site Name
            </th>
            <th scope="col">
              Job Title
            </th>
            <th
              scope="col"
              class="text-center"
            >
              Busniness Name
            </th>
            <th>
              Busniness Address
            </th>
            <th
              scope="col"
              class="text-center"
            >
             Officer
            </th>
            <th scope="col">
              Home Telephone
            </th>
            <th scope="col">
              Email
            </th>
            <th scope="col">
              ACTIONS
            </th>
          </tr>
        </thead>

        <!-- 👉 table body -->
        <tbody>
          <tr
            v-for="srrequest in srrequests"
            :key="srrequest.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ srrequest.id }}
            </td>
            <td>
              {{ srrequest.site_name   }}
            </td>
            <td>
              {{ srrequest.job_title  }}
            </td>
            <td>
              {{srrequest.busniness_name }}
            </td> 
            <td>
               {{ srrequest.busniness_address }} 
            </td> 
            <td>
              {{ srrequest.officer_id }}
            </td> 
             <td>
              {{ srrequest.home_telephone }}
            </td> 
            <td >
               {{ srrequest.email }}
            </td> 
            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
              <VBtn 
                :to="`/ServiceRequestList/${srrequest.id}/details`"
                color="light"
              >
                <VIcon icon="mdi-eye-outline" :to="`/ServiceRequestList/${srrequest.id}/details`"/>
              </VBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot >
          <tr >
            <td
              colspan="5"
              class="text-center"
            >
              No matching records found.
            </td>
          </tr>
        </tfoot>
      </VTable>

      <VDivider />

      <VCardText class="d-flex align-center flex-wrap justify-end gap-4 pa-2">
        <div
          class="d-flex align-center me-3"
          style="width: 171px;"
        >
          <span class="text-no-wrap me-3">Rows per page:</span>

          <VSelect
            v-model="rowPerPage"
            density="compact"
            variant="plain"
            class="mt-n4"
            :items="[25, 50, 100, 200,500]"
          />
        </div>

        <div class="d-flex align-center">
          <h6 class="text-sm font-weight-regular">
            {{ paginationData }}
          </h6>

          <VPagination
            v-model="currentPage"
            size="small"
            :total-visible="1"
            :length="totalPage"
            
          />
        </div>
      </VCardText>
    </VCard>

    <!-- 👉 Add New Enviro -->
    
    <AddEditEnviroDialog
      v-model:isDialogOpen="isAddEditEnviroDialogVisible"
      @enviroadd-data="addNewEnviro"
      @enviroupdate-data="updateEnviro"
      :selected-enviro="selectedItem"
    />
    
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
  </section>
</template>

<style lang="scss">
.app-user-search-filter {
  inline-size: 24.0625rem;
}

.text-capitalize {
  text-transform: capitalize;
}

.user-list-name:not(:hover) {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.tbc th{
  text-align:left!important;
}
.no-bg {
   background: none!important;
}
</style>
