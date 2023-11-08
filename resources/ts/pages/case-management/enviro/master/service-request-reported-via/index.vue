<script setup lang="ts">
import AddEditServiceRequestReportedViaDialog from '@/pages/case-management/enviro/master/service-request-reported-via/AddEditServiceRequestReportedViaDialog.vue';
import type { ServiceRequestReportedViaProperties } from '@/pages/case-management/enviro/master/service-request-reported-via/types';
import { useServiceRequestReportedViaListStore } from '@/pages/case-management/enviro/master/service-request-reported-via/useServiceRequestReportedViaListStore';
// 👉 Store
const ServiceRequestReportedViaListStore = useServiceRequestReportedViaListStore()
const searchQuery = ref('') 
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalServiceRequestReportedViaItems = ref(0)
const ServiceRequestReportedViaItems = ref<ServiceRequestReportedViaProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
// 👉 Fetching ServiceRequestReportedViaItems
const fetchServiceRequestReportedViaItems = () => {
isTableLoading.value = true
ServiceRequestReportedViaListStore.fetchServiceRequestReportedViaItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    ServiceRequestReportedViaItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalServiceRequestReportedViaItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchServiceRequestReportedViaItems)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 search filters

const status = [
{ title: 'All', value: '' },
  { title: 'Active', value: '1' },
  { title: 'Inactive', value: '0' },
]

const isAddEditServiceRequestReportedViaDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = ServiceRequestReportedViaItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = ServiceRequestReportedViaItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalServiceRequestReportedViaItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new offencelocationprefix
const addNewServiceRequestReportedVia = (ServiceRequestReportedViaData: ServiceRequestReportedViaProperties) => {
  ServiceRequestReportedViaListStore.addServiceRequestReportedVia(ServiceRequestReportedViaData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchServiceRequestReportedViaItems()
  }).catch(error => {
    alertMessage.value= error.response.data.message;
    alertType.value='error'
    isAlertVisible.value=true
    console.error(error.response.data.message)
  })
}

const updateStatusServiceRequestReportedVia = (id:number  , status:string) => {
  ServiceRequestReportedViaListStore.updateServiceRequestReportedViaStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}

const updateBackOfficeServiceRequestReportedVia = (id:number  , back_office:string) => {
  ServiceRequestReportedViaListStore.updateServiceRequestReportedViaBackOffice(id,back_office)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}

const updateOnlineServiceRequestReportedVia = (id:number  , online:string) => {
  ServiceRequestReportedViaListStore.updateServiceRequestReportedViaOnline(id,online)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}


const updateServiceRequestReportedVia = (ServiceRequestReportedViaData: ServiceRequestReportedViaProperties) => {
  ServiceRequestReportedViaListStore.updateServiceRequestReportedVia(ServiceRequestReportedViaData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchServiceRequestReportedViaItems()
  }).catch(error => {
    alertMessage.value= error.response.data.message;
    alertType.value='error'
    isAlertVisible.value=true
    console.error(error)
  })
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
        </VRow>
      </VCardText>
    </VCard>

    <VCard >
      <VCardText class="d-flex flex-wrap gap-2">
       <VCardTitle class="px-0">Service Request Reported Via Details </VCardTitle>
        <!-- 👉 Export button -->
        <VSpacer />

        <div class="app-user-search-filter d-flex align-center gap-6" >
          <!-- 👉 Search  -->
          <VTextField
            v-model="searchQuery"
            placeholder="Search"
            density="compact"
          />

          <!-- 👉 Add offencelocationprefix button -->
          <VBtn @click="selectedItem={};isAddEditServiceRequestReportedViaDialogVisible = true">
            Add 
          </VBtn>
        </div>
      </VCardText>

      <VDivider />
<VProgressLinear
v-if="isTableLoading"
    indeterminate
    color="primary"
  />
      <VTable class="text-no-wrap table-header-bg rounded-0">
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
              Reported via 
            </th>

            <th scope="col">
              Is Active? 
            </th>

            <th scope="col">
              Is Back Office?
            </th>

            <th scope="col">
              Is Online?
            </th>

            <th scope="col">
              ACTIONS
            </th>
          </tr>
        </thead>

        <!-- 👉 table body -->
        <tbody>
          <tr
            v-for="serviceRequestReportedViaItem in ServiceRequestReportedViaItems"
            :key="serviceRequestReportedViaItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ serviceRequestReportedViaItem.id }}
            </td>
           <!-- 👉 Text On Reported Via -->
            <td>
              {{ serviceRequestReportedViaItem.reported_via }}
            </td> 
            
            <!-- 👉 Status -->
            <td>
              
              <VSwitch
                  v-model="serviceRequestReportedViaItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusServiceRequestReportedVia(serviceRequestReportedViaItem.id,serviceRequestReportedViaItem.status)"
                  
                />
            </td>

             <!-- 👉 Back Office -->
            <td>
              
              <VSwitch
                  v-model="serviceRequestReportedViaItem.is_back_office"
                  true-value="1"
                  false-value="0"
                  @change="updateBackOfficeServiceRequestReportedVia(serviceRequestReportedViaItem.id,serviceRequestReportedViaItem.is_back_office)"
                  
                />
            </td>

             <!-- 👉 Online -->
            <td>
              
              <VSwitch
                  v-model="serviceRequestReportedViaItem.is_online"
                  true-value="1"
                  false-value="0"
                  @change="updateOnlineServiceRequestReportedVia(serviceRequestReportedViaItem.id,serviceRequestReportedViaItem.is_online)"
                  
                />
            </td>

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=serviceRequestReportedViaItem;isAddEditServiceRequestReportedViaDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!ServiceRequestReportedViaItems.length">
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

    <!-- 👉 Add New Offence Location Prefix -->
    
    <AddEditServiceRequestReportedViaDialog
      v-model:isDialogOpen="isAddEditServiceRequestReportedViaDialogVisible"
      @serviceRequestReportedViaadd-data="addNewServiceRequestReportedVia"
      @serviceRequestReportedViaupdate-data="updateServiceRequestReportedVia"
      :selected-serviceRequestReportedVia="selectedItem"
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
</style>
  