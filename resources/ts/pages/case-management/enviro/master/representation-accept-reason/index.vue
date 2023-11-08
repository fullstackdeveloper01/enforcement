<script setup lang="ts">
import AddEditRepresentationAcceptReasonDialog from '@/pages/case-management/enviro/master/representation-accept-reason/AddEditRepresentationAcceptReasonDialog.vue';
import type { RepresentationAcceptReasonProperties } from '@/pages/case-management/enviro/master/representation-accept-reason/types';
import { useRepresentationAcceptReasonListStore } from '@/pages/case-management/enviro/master/representation-accept-reason/useRepresentationAcceptReasonListStore';
// 👉 Store
const RepresentationAcceptReasonListStore = useRepresentationAcceptReasonListStore()
const searchQuery = ref('') 
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalRepresentationAcceptReasonItems = ref(0)
const RepresentationAcceptReasonItems = ref<RepresentationAcceptReasonProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
// 👉 Fetching representationAcceptReasonItems
const fetchRepresentationAcceptReasonItems = () => {
isTableLoading.value = true
RepresentationAcceptReasonListStore.fetchRepresentationAcceptReasonItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    RepresentationAcceptReasonItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalRepresentationAcceptReasonItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchRepresentationAcceptReasonItems)

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

const isAddEditRepresentationAcceptReasonDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = RepresentationAcceptReasonItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = RepresentationAcceptReasonItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalRepresentationAcceptReasonItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new offencelocationprefix
const addNewRepresentationAcceptReason = (representationAcceptReasonData: RepresentationAcceptReasonProperties) => {
  RepresentationAcceptReasonListStore.addRepresentationAcceptReason(representationAcceptReasonData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchRepresentationAcceptReasonItems()
  }).catch(error => {
    console.error(error)
  })
}

const updateStatusRepresentationAcceptReason = (id:number  , status:string) => {
  RepresentationAcceptReasonListStore.updateRepresentationAcceptReasonStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}
const updateRepresentationAcceptReason = (representationAcceptReasonData: RepresentationAcceptReasonProperties) => {
  RepresentationAcceptReasonListStore.updateRepresentationAcceptReason(representationAcceptReasonData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchRepresentationAcceptReasonItems()
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
       <VCardTitle class="px-0">Representation Accept Reason Details </VCardTitle>
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
          <VBtn @click="selectedItem={};isAddEditRepresentationAcceptReasonDialogVisible = true">
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
            v-for="representationAcceptReasonItem in RepresentationAcceptReasonItems"
            :key="representationAcceptReasonItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ representationAcceptReasonItem.id }}
            </td>
           <!-- 👉 Text On reason -->
            <td>
              {{ representationAcceptReasonItem.reason }}
            </td> 
            
            <!-- 👉 Status -->
            <td>
              
              <VSwitch
                  v-model="representationAcceptReasonItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusRepresentationAcceptReason(representationAcceptReasonItem.id,representationAcceptReasonItem.status)"
                  
                />
            </td>

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=representationAcceptReasonItem;isAddEditRepresentationAcceptReasonDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!RepresentationAcceptReasonItems.length">
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
    
    <AddEditRepresentationAcceptReasonDialog
      v-model:isDialogOpen="isAddEditRepresentationAcceptReasonDialogVisible"
      @representationacceptreasonadd-data="addNewRepresentationAcceptReason"
      @representationacceptreasonupdate-data="updateRepresentationAcceptReason"
      :selected-representationAcceptReason="selectedItem"
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
  