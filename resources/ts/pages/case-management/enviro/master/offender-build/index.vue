<script setup lang="ts">
import AddEditOffenderBuildDialog from '@/pages/case-management/enviro/master/offender-build/AddEditOffenderBuildDialog.vue';
import type { OffenderBuildProperties } from '@/pages/case-management/enviro/master/offender-build/types';
import { useOffenderBuildListStore } from '@/pages/case-management/enviro/master/offender-build/useOffenderBuildListStore';
// 👉 Store
const offenderBuildListStore = useOffenderBuildListStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalOffenderBuildItems = ref(0)
const offenderBuildItems = ref<OffenderBuildProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
// 👉 Fetching offenderbuilditems
const fetchOffenderBuildItems = () => {
isTableLoading.value = true
  offenderBuildListStore.fetchOffenderBuildItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    offenderBuildItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalOffenderBuildItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchOffenderBuildItems)

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

const isAddEditOffenderBuildDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = offenderBuildItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = offenderBuildItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalOffenderBuildItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new offenderbuild
const addNewOffenderBuild = (offenderBuildData: OffenderBuildProperties) => {
  offenderBuildListStore.addOffenderBuild(offenderBuildData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
  // refetch User
  fetchOffenderBuildItems()
}

const updateStatusOffenderBuild = (id:number  , status:string) => {
  offenderBuildListStore.updateOffenderBuildStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}
const updateOffenderBuild = (offenderBuildData: OffenderBuildProperties) => {
  offenderBuildListStore.updateOffenderBuild(offenderBuildData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
  // refetch User
  fetchOffenderBuildItems()
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
       <VCardTitle class="px-0">Offender Build Details </VCardTitle>
        <!-- 👉 Export button -->
      

        <VSpacer />

        <div class="app-user-search-filter d-flex align-center gap-6">
          <!-- 👉 Search  -->
          <VTextField
            v-model="searchQuery"
            placeholder="Search"
            density="compact"
          />

          <!-- 👉 Add offenderbuild button -->
          <VBtn @click="selectedItem={};isAddEditOffenderBuildDialogVisible = true">
            Add Offender Build
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
              Text On Machine 
            </th>
            <th scope="col">
              Text On Letter
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
            v-for="offenderBuildItem in offenderBuildItems"
            :key="offenderBuildItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ offenderBuildItem.id }}
            </td>
           <!-- 👉 Text On Machine -->
            <td>
              {{ offenderBuildItem.textOnMachine }}
            </td> 
            <!-- 👉 Text On Letter -->
            <td>
              {{ offenderBuildItem.textOnLetter }}
            </td> 
            
            <!-- 👉 Status -->
            <td>
              
              <VSwitch
                  v-model="offenderBuildItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusOffenderBuild(offenderBuildItem.id,offenderBuildItem.status)"
                  
                />
            </td>

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=offenderBuildItem;isAddEditOffenderBuildDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!offenderBuildItems.length">
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

    <!-- 👉 Add New Offender Build -->
    
    <AddEditOffenderBuildDialog
      v-model:isDialogOpen="isAddEditOffenderBuildDialogVisible"
      @offenderbuildadd-data="addNewOffenderBuild"
      @offenderbuildupdate-data="updateOffenderBuild"
      :selected-offenderbuild="selectedItem"
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
