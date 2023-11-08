<script setup lang="ts">
import AddEditServiceRequestTaskGroupDialog from '@/pages/case-management/enviro/master/service-request-task-group/AddEditServiceRequestTaskGroupDialog.vue';
import type { ServiceRequestTaskGroupProperties } from '@/pages/case-management/enviro/master/service-request-task-group/types';
import { useServiceRequestTaskGroupListStore } from '@/pages/case-management/enviro/master/service-request-task-group/useServiceRequestTaskGroupListStore';
import { siteStore } from '@/pages/setup/sites/siteStore';

// 👉 Store
const ServiceRequestTaskGroupListStore = useServiceRequestTaskGroupListStore()
const searchQuery = ref('') 
const selectedStatus = ref('')
const selectedSites = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalServiceRequestTaskGroupItems = ref(0)
const ServiceRequestTaskGroupItems = ref<ServiceRequestTaskGroupProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
const siteStores = siteStore()
const siteList = ref([]);
// 👉 Fetching ServiceRequestTaskGroupItems
const fetchServiceRequestTaskGroupItems = () => {
isTableLoading.value = true
ServiceRequestTaskGroupListStore.fetchServiceRequestTaskGroupItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    sites: selectedSites.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    ServiceRequestTaskGroupItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalServiceRequestTaskGroupItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchServiceRequestTaskGroupItems)

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

const isAddEditServiceRequestTaskGroupDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = ServiceRequestTaskGroupItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = ServiceRequestTaskGroupItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalServiceRequestTaskGroupItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new offencelocationprefix
const addNewServiceRequestTaskGroup = (ServiceRequestTaskGroupData: ServiceRequestTaskGroupProperties) => {
  ServiceRequestTaskGroupListStore.addServiceRequestTaskGroup(ServiceRequestTaskGroupData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchServiceRequestTaskGroupItems()
  }).catch(error => {
    alertMessage.value= error.response.data.message;
    alertType.value='error'
    isAlertVisible.value=true
    console.error(error.response.data.message)
  })
}

const updateStatusServiceRequestTaskGroup = (id:number  , status:string) => {
  ServiceRequestTaskGroupListStore.updateServiceRequestTaskGroupStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}



const updateServiceRequestTaskGroup = (ServiceRequestTaskGroupData: ServiceRequestTaskGroupProperties) => {
  ServiceRequestTaskGroupListStore.updateServiceRequestTaskGroup(ServiceRequestTaskGroupData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchServiceRequestTaskGroupItems()
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
       <VCardTitle class="px-0">Service Request Task Group Details </VCardTitle>
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
          <VBtn @click="selectedItem={};isAddEditServiceRequestTaskGroupDialogVisible = true">
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
              Site Name 
            </th>

            <th scope="col">
              Task Group Name 
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
            v-for="serviceRequestTaskGroupItem in ServiceRequestTaskGroupItems"
            :key="serviceRequestTaskGroupItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ serviceRequestTaskGroupItem.id }}
            </td>

            <!-- 👉 Text On Task Group Name -->
            <td>
              {{ serviceRequestTaskGroupItem.task_type_task_group[0].sites.name }}
            </td> 

            <!-- 👉 Text On Task Group Name -->
            <td>
              {{ serviceRequestTaskGroupItem.task_group_name }}
            </td> 
            
            <!-- 👉 Status -->
            <td>
              <VSwitch
                  v-model="serviceRequestTaskGroupItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusServiceRequestTaskGroup(serviceRequestTaskGroupItem.id,serviceRequestTaskGroupItem.status)"
                  
                />
            </td>

            

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=serviceRequestTaskGroupItem;isAddEditServiceRequestTaskGroupDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!ServiceRequestTaskGroupItems.length">
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
    
    <AddEditServiceRequestTaskGroupDialog
      v-model:isDialogOpen="isAddEditServiceRequestTaskGroupDialogVisible"
      @serviceRequestTaskGroupadd-data="addNewServiceRequestTaskGroup"
      @serviceRequestTaskGroupupdate-data="updateServiceRequestTaskGroup"
      :selected-serviceRequestTaskGroup="selectedItem"
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
  