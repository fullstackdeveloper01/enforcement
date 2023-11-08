<script setup lang="ts">
import AddEditWasteTypeDialog from '@/pages/case-management/enviro/master/waste-type/AddEditWasteTypeDialog.vue';
import type { WasteTypeProperties } from '@/pages/case-management/enviro/master/waste-type/types';
import { useWasteTypeListStore } from '@/pages/case-management/enviro/master/waste-type/useWasteTypeListStore';
// 👉 Store
const WasteTypeListStore = useWasteTypeListStore()
const searchQuery = ref('') 
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalWasteTypeItems = ref(0)
const WasteTypeItems = ref<WasteTypeProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
// 👉 Fetching wastetypeItems
const fetchWasteTypeItems = () => {
isTableLoading.value = true
WasteTypeListStore.fetchWasteTypeItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    WasteTypeItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalWasteTypeItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchWasteTypeItems)

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

const isAddEditWasteTypeDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = WasteTypeItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = WasteTypeItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalWasteTypeItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new waste type
const addNewWasteType = (WasteTypeData: WasteTypeProperties) => {
  WasteTypeListStore.addWasteType(WasteTypeData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchWasteTypeItems()
  }).catch(error => {
    console.error(error)
  })
}

const updateStatusWasteType = (id:number  , status:string) => {
  WasteTypeListStore.updateWasteTypeStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}
const updateWasteType = (WasteTypeData: WasteTypeProperties) => {
  WasteTypeListStore.updateWasteType(WasteTypeData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchWasteTypeItems()
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
       <VCardTitle class="px-0">Waste Type Details </VCardTitle>
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
          <VBtn @click="selectedItem={};isAddEditWasteTypeDialogVisible = true">
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
              Waste Type 
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
            v-for="wasteTypeItem in WasteTypeItems"
            :key="wasteTypeItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ wasteTypeItem.id }}
            </td>
           <!-- 👉 Text On reason -->
            <td>
              {{ wasteTypeItem.waste_type }}
            </td> 
            
            <!-- 👉 Status -->
            <td>
              
              <VSwitch
                  v-model="wasteTypeItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusWasteType(wasteTypeItem.id,wasteTypeItem.status)"
                  
                />
            </td>

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=wasteTypeItem;isAddEditWasteTypeDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!WasteTypeItems.length">
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
    
    <AddEditWasteTypeDialog
      v-model:isDialogOpen="isAddEditWasteTypeDialogVisible"
      @wastetypeadd-data="addNewWasteType"
      @wastetypeupdate-data="updateWasteType"
      :selected-wasteType="selectedItem"
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
  