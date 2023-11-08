<script setup lang="ts">
import AddEditServiceRequestTaskTypeDialog from '@/pages/case-management/enviro/master/service-request-task-type/AddEditServiceRequestTaskTypeDialog.vue';
import type { ServiceRequestTaskTypeProperties } from '@/pages/case-management/enviro/master/service-request-task-type/types';
import { useServiceRequestTaskTypeListStore } from '@/pages/case-management/enviro/master/service-request-task-type/useServiceRequestTaskTypeListStore';
import { siteStore } from '@/pages/setup/sites/siteStore';

// 👉 Store
const ServiceRequestTaskTypeListStore = useServiceRequestTaskTypeListStore()
const searchQuery = ref('') 
const selectedStatus = ref('')
const selectedSites = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalServiceRequestTaskTypeItems = ref(0)
const ServiceRequestTaskTypeItems = ref<ServiceRequestTaskTypeProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
const siteStores = siteStore()
const siteList = ref([]);
// 👉 Fetching ServiceRequestTaskTypeItems
const fetchServiceRequestTaskTypeItems = () => {
isTableLoading.value = true
ServiceRequestTaskTypeListStore.fetchServiceRequestTaskTypeItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    sites: selectedSites.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    ServiceRequestTaskTypeItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalServiceRequestTaskTypeItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchServiceRequestTaskTypeItems)

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

const isAddEditServiceRequestTaskTypeDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = ServiceRequestTaskTypeItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = ServiceRequestTaskTypeItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalServiceRequestTaskTypeItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new offencelocationprefix
const addNewServiceRequestTaskType = (ServiceRequestTaskTypeData: ServiceRequestTaskTypeProperties) => {
  ServiceRequestTaskTypeListStore.addServiceRequestTaskType(ServiceRequestTaskTypeData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchServiceRequestTaskTypeItems()
  }).catch(error => {
    alertMessage.value= error.response.data.message;
    alertType.value='error'
    isAlertVisible.value=true
    console.error(error.response.data.message)
  })
}

const updateStatusServiceRequestTaskType = (id:number  , status:string) => {
  ServiceRequestTaskTypeListStore.updateServiceRequestTaskTypeStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}



const updateServiceRequestTaskType = (ServiceRequestTaskTypeData: ServiceRequestTaskTypeProperties) => {
  ServiceRequestTaskTypeListStore.updateServiceRequestTaskType(ServiceRequestTaskTypeData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchServiceRequestTaskTypeItems()
  }).catch(error => {
    alertMessage.value= error.response.data.message;
    alertType.value='error'
    isAlertVisible.value=true
    console.error(error)
  })
}

siteStores.fetchAllSites().then(response => {
  let res = response.data.data;
  let lists:any = [{ name: 'All', id: '' }];
   res.forEach((item: any) => {
    let id = item.id;
    let name = item.name;
    let list = {
      id: id,
      name: name
    }
    lists.push(list)
    siteList.value = lists;
  });
});
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
            <VSelect
              v-model="selectedSites"
              label="Select Sites"
              :items="siteList"
              item-title="name"
                item-value="id"
              clear-icon="mdi-close"
            />
          </VCol>
        </VRow>
      </VCardText>
    </VCard>

    <VCard >
      <VCardText class="d-flex flex-wrap gap-2">
       <VCardTitle class="px-0">Service Request Task Type Details </VCardTitle>
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
          <VBtn @click="selectedItem={};isAddEditServiceRequestTaskTypeDialogVisible = true">
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
              Task Type Name 
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
            v-for="serviceRequestTaskTypeItem in ServiceRequestTaskTypeItems"
            :key="serviceRequestTaskTypeItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ serviceRequestTaskTypeItem.id }}
            </td>

            <!-- 👉 Text On Task type Name -->
            <td>
              {{ serviceRequestTaskTypeItem.task_type_name }}
            </td> 
            
            <!-- 👉 Status -->
            <td>
              <VSwitch
                  v-model="serviceRequestTaskTypeItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusServiceRequestTaskType(serviceRequestTaskTypeItem.id,serviceRequestTaskTypeItem.status)"
                  
                />
            </td>

            

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=serviceRequestTaskTypeItem;isAddEditServiceRequestTaskTypeDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!ServiceRequestTaskTypeItems.length">
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
    
    <AddEditServiceRequestTaskTypeDialog
      v-model:isDialogOpen="isAddEditServiceRequestTaskTypeDialogVisible"
      @serviceRequestTaskTypeadd-data="addNewServiceRequestTaskType"
      @serviceRequestTaskTypeupdate-data="updateServiceRequestTaskType"
      :selected-serviceRequestTaskType="selectedItem"
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
  