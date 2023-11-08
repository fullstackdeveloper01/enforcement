<script setup lang="ts">
import AddEditRegionDialog from '@/pages/case-management/enviro/master/region/AddEditRegionDialog.vue';
import type { RegionProperties } from '@/pages/case-management/enviro/master/region/types';
import { useRegionListStore } from '@/pages/case-management/enviro/master/region/useRegionListStore';
// 👉 Store
const regionListStore = useRegionListStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalRegionItems = ref(0)
const regionItems = ref<RegionProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
// 👉 Fetching offencehowitems
const fetchRegionItems = () => {
isTableLoading.value = true
  regionListStore.fetchRegionItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    regionItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalRegionItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(e => {    
    const { message } = e.response.data;
    alertMessage.value=message
    alertType.value='error'
    isAlertVisible.value=true
  })
}

watchEffect(fetchRegionItems)

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

const isAddEditRegionDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = regionItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = regionItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalRegionItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new offencehow
const addNewRegion = (offenceHowData: RegionProperties) => {
  regionListStore.addRegion(offenceHowData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(e => {
    isAddEditRegionDialogVisible.value=true
    const { message } = e.response.data;
    alertMessage.value=message
    alertType.value='error'
    isAlertVisible.value=true
  })
  // refetch User
  fetchRegionItems()
}

const updateStatusRegion = (id:number  , status:string) => {
  regionListStore.updateRegionStatus(id,status)
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
const updateRegion = (offenceHowData: RegionProperties) => {
  regionListStore.updateRegion(offenceHowData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(e => {
    isAddEditRegionDialogVisible.value=true
    const { message } = e.response.data;
    alertMessage.value=message
    alertType.value='error'
    isAlertVisible.value=true
  })
  // refetch User
  fetchRegionItems()
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
       <VCardTitle class="px-0">Region Details </VCardTitle>
        <!-- 👉 Export button -->
      

        <VSpacer />

        <div class="app-user-search-filter d-flex align-center gap-6">
          <!-- 👉 Search  -->
          <VTextField
            v-model="searchQuery"
            placeholder="Search"
            density="compact"
          />

          <!-- 👉 Add offencehow button -->
          <VBtn @click="selectedItem={};isAddEditRegionDialogVisible = true">
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
              Region
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
            v-for="regionItem in regionItems"
            :key="regionItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ regionItem.id }}
            </td>
            <!-- 👉 Text On Letter -->
            <td>
              {{ regionItem.region }}
            </td> 
            
            <!-- 👉 Status -->
            <td>
              
              <VSwitch
                  v-model="regionItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusRegion(regionItem.id,regionItem.status)"
                  
                />
            </td>

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=regionItem;isAddEditRegionDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!regionItems.length">
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

    <!-- 👉 Add New Region-->
    
    <AddEditRegionDialog
      v-model:isDialogOpen="isAddEditRegionDialogVisible"
      @regionadd-data="addNewRegion"
      @regionupdate-data="updateRegion"
      :selected-region="selectedItem"
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
