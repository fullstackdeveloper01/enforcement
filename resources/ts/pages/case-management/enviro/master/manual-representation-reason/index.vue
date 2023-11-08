<script setup lang="ts">
import AddEditManualRepresentationReasonDialog from '@/pages/case-management/enviro/master/manual-representation-reason/AddEditManualRepresentationReasonDialog.vue';
import type { ManualRepresentationReasonProperties } from '@/pages/case-management/enviro/master/manual-representation-reason/types';
import { useManualRepresentationReasonListStore } from '@/pages/case-management/enviro/master/manual-representation-reason/useManualRepresentationReasonListStore';
// 👉 Store
const manualRepresentationReasonListStore = useManualRepresentationReasonListStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalManualRepresentationReasonItems = ref(0)
const manualRepresentationReasonItems = ref<ManualRepresentationReasonProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
// 👉 Fetching manualRepresentationReasonitems
const fetchManualRepresentationReasonItems = () => {
isTableLoading.value = true
manualRepresentationReasonListStore.fetchManualRepresentationReasonItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    console.log("It's running ")
    manualRepresentationReasonItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalManualRepresentationReasonItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchManualRepresentationReasonItems)

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

const isAddEditManualRepresentationReasonDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = manualRepresentationReasonItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = manualRepresentationReasonItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalManualRepresentationReasonItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new offencelocationprefix
const addNewManualRepresentationReason = (manualRepresentationReasonData: ManualRepresentationReasonProperties) => {
  manualRepresentationReasonListStore.addManualRepresentationReason(manualRepresentationReasonData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchManualRepresentationReasonItems()
  }).catch(error => {
    console.error(error)
  })
}

const updateStatusManualRepresentationReason = (id:number  , status:string) => {
  manualRepresentationReasonListStore.updateManualRepresentationReasonStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}
const updateManualRepresentationReason = (manualRepresentationReasonData: ManualRepresentationReasonProperties) => {
  manualRepresentationReasonListStore.updateManualRepresentationReason(manualRepresentationReasonData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchManualRepresentationReasonItems()
  }).catch(error => {
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
       <VCardTitle class="px-0">Manual Representation Reason Details </VCardTitle>
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
          <VBtn @click="selectedItem={};isAddEditManualRepresentationReasonDialogVisible = true">
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
              Reason 
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
            v-for="manualRepresentationReasonItem in manualRepresentationReasonItems"
            :key="manualRepresentationReasonItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ manualRepresentationReasonItem.id }}
            </td>
           <!-- 👉 Text On reason -->
            <td>
              {{ manualRepresentationReasonItem.reason }}
            </td> 
            
            <!-- 👉 Status -->
            <td>
              
              <VSwitch
                  v-model="manualRepresentationReasonItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusManualRepresentationReason(manualRepresentationReasonItem.id,manualRepresentationReasonItem.status)"
                  
                />
            </td>

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=manualRepresentationReasonItem;isAddEditManualRepresentationReasonDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!manualRepresentationReasonItems.length">
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
    
    <AddEditManualRepresentationReasonDialog
      v-model:isDialogOpen="isAddEditManualRepresentationReasonDialogVisible"
      @manualrepresentationreasonadd-data="addNewManualRepresentationReason"
      @manualrepresentationreasonupdate-data="updateManualRepresentationReason"
      :selected-manualRepresentationReason="selectedItem"
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
  