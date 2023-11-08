<script setup lang="ts">
import AddEditServiceRequestTypeDialog from '@/pages/case-management/enviro/master/service-request-type/AddEditServiceRequestTypeDialog.vue';
import type { ServiceRequestTypeProperties } from '@/pages/case-management/enviro/master/service-request-type/types';
import { useServiceRequestTypeListStore } from '@/pages/case-management/enviro/master/service-request-type/useServiceRequestTypeListStore';
// 👉 Store
const ServiceRequestTypeListStore = useServiceRequestTypeListStore()
const searchQuery = ref('') 
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalServiceRequestTypeItems = ref(0)
const ServiceRequestTypeItems = ref<ServiceRequestTypeProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
// 👉 Fetching ServiceRequestTypeItems
const fetchServiceRequestTypeItems = () => {
isTableLoading.value = true
ServiceRequestTypeListStore.fetchServiceRequestTypeItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    ServiceRequestTypeItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalServiceRequestTypeItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchServiceRequestTypeItems)

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

const isAddEditServiceRequestTypeDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = ServiceRequestTypeItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = ServiceRequestTypeItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalServiceRequestTypeItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new offencelocationprefix
const addNewServiceRequestType = (ServiceRequestTypeData: ServiceRequestTypeProperties) => {
  ServiceRequestTypeListStore.addServiceRequestType(ServiceRequestTypeData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchServiceRequestTypeItems()
  }).catch(error => {
    alertMessage.value= error.response.data.message;
    alertType.value='error'
    isAlertVisible.value=true
    console.error(error.response.data.message)
  })
}

const updateStatusServiceRequestType = (id:number  , status:string) => {
  ServiceRequestTypeListStore.updateServiceRequestTypeStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}
const updateServiceRequestType = (serviceRequestTypeData: ServiceRequestTypeProperties) => {
  ServiceRequestTypeListStore.updateServiceRequestType(serviceRequestTypeData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchServiceRequestTypeItems()
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
       <VCardTitle class="px-0">Service Request Type Details </VCardTitle>
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
          <VBtn @click="selectedItem={};isAddEditServiceRequestTypeDialogVisible = true">
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
              Type Name 
            </th>

            <th scope="col">
              Minimum Images Required 
            </th>
            
            <th scope="col">
              Status
            </th>
            <th scope="col">
              ACTIONS
            </th>
          </tr>
        </thead>

        <!-- 👉 table body -->
        <tbody>
          <tr
            v-for="serviceRequestTypeItem in ServiceRequestTypeItems"
            :key="serviceRequestTypeItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ serviceRequestTypeItem.id }}
            </td>
           <!-- 👉 Text On type name -->
            <td>
              {{ serviceRequestTypeItem.type_name }}
            </td> 
            <!-- 👉 Text On type minimum images required -->
            <td>
              {{ serviceRequestTypeItem.minimum_images_required }}
            </td> 
            
            <!-- 👉 Status -->
            <td>
              
              <VSwitch
                  v-model="serviceRequestTypeItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusServiceRequestType(serviceRequestTypeItem.id,serviceRequestTypeItem.status)"
                  
                />
            </td>

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=serviceRequestTypeItem;isAddEditServiceRequestTypeDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!ServiceRequestTypeItems.length">
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
    
    <AddEditServiceRequestTypeDialog
      v-model:isDialogOpen="isAddEditServiceRequestTypeDialogVisible"
      @serviceRequestTypeadd-data="addNewServiceRequestType"
      @serviceRequestTypeupdate-data="updateServiceRequestType"
      :selected-serviceRequestType="selectedItem"
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
  