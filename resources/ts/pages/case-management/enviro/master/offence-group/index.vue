<script setup lang="ts">
import AddEditOffenceGroupDialog from '@/pages/case-management/enviro/master/offence-group/AddEditOffenceGroupDialog.vue';
import type { OffenceGroupProperties } from '@/pages/case-management/enviro/master/offence-group/types';
import { useOffenceGroupListStore } from '@/pages/case-management/enviro/master/offence-group/useOffenceGroupListStore';
// 👉 Store
const offenceGroupListStore = useOffenceGroupListStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalOffenceGroupItems = ref(0)
const offenceGroupItems = ref<OffenceGroupProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
// 👉 Fetching offenceGroupItems
const fetchOffenceGroupItems = () => {
  isTableLoading.value = true
  offenceGroupListStore.fetchOffenceGroupItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    offenceGroupItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalOffenceGroupItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(e => {
    const { message } = e.response.data;
    alertMessage.value=message
    alertType.value='error'
    isAlertVisible.value=true
  })
}

watchEffect(fetchOffenceGroupItems)

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

const isAddEditOffenceGroupDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = offenceGroupItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = offenceGroupItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalOffenceGroupItems.value}`
})

// 👉 Add new OffenceGroup
const addNewOffenceGroup = (offenceHowData: OffenceGroupProperties) => {
  offenceGroupListStore.addOffenceGroup(offenceHowData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(e => {
    isAddEditOffenceGroupDialogVisible.value=true
    const { message } = e.response.data;
    alertMessage.value=message
    alertType.value='error'
    isAlertVisible.value=true
  })
  // refetch User
  fetchOffenceGroupItems()
}

const updateStatusOffenceGroup = (id:number  , status:string) => {
  offenceGroupListStore.updateOffenceGroupStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(e => {
    const { message } = e.response.data;
    alertMessage.value=message
    alertType.value='error'
    isAlertVisible.value=true
  })
}
const updateOffenceGroup = (offenceHowData: OffenceGroupProperties) => {
  offenceGroupListStore.updateOffenceGroup(offenceHowData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(e => {
    isAddEditOffenceGroupDialogVisible.value=true
    const { message } = e.response.data;
    alertMessage.value=message
    alertType.value='error'
    isAlertVisible.value=true
  })
  // refetch User
  fetchOffenceGroupItems()
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
      <VCardText class="d-flex flex-wrap gap-4">
       <VCardTitle class="px-0">Offence Group Details </VCardTitle>
        <!-- 👉 Export button -->
      

        <VSpacer />

        <div class="app-user-search-filter d-flex align-center gap-6">
          <!-- 👉 Search  -->
          <VTextField
            v-model="searchQuery"
            placeholder="Search"
            density="compact"
          />

          <!-- 👉 Add OffenceGroup button -->
          <VBtn @click="selectedItem={};isAddEditOffenceGroupDialogVisible = true">
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
              Offence Group Name (English) 
            </th>
            <th scope="col">
              Offence Group Name (Welsh) 
            </th>
            <th scope="col">
              Offence Group Type
            </th>            
            <th scope="col">
              Active
            </th>
            <th scope="col">
              ACTIONS
            </th>
          </tr>
        </thead>

        <!-- 👉 table body -->
        <tbody>
          <tr
            v-for="offenceGroupItem in offenceGroupItems"
            :key="offenceGroupItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ offenceGroupItem.id }}
            </td>
           <!-- 👉 Text On Machine -->
            <td>
              {{ offenceGroupItem.englishName }}
            </td> 
            <!-- 👉 Text On Letter -->
            <td>
              {{ offenceGroupItem.welshName }}
            </td> 
            <td>
              {{ offenceGroupItem.type }}
            </td>
            
            <!-- 👉 Status -->
            <td>
              
              <VSwitch
                  v-model="offenceGroupItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusOffenceGroup(offenceGroupItem.id,offenceGroupItem.status)"
                  
                />
            </td>

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
              <IconBtn @click="selectedItem=offenceGroupItem;isAddEditOffenceGroupDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!offenceGroupItems.length">
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

    <!-- 👉 Add New BWC -->
    
    <AddEditOffenceGroupDialog
      v-model:isDialogOpen="isAddEditOffenceGroupDialogVisible"
      @offencegroupadd-data="addNewOffenceGroup"
      @offencegroupupdate-data="updateOffenceGroup"
      :selected-offencegroup="selectedItem"
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
