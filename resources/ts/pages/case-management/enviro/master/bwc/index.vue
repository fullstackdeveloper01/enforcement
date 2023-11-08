<script setup lang="ts">
import AddEditBwcDialog from '@/pages/case-management/enviro/master/bwc/AddEditBwcDialog.vue';
import type { BwcProperties } from '@/pages/case-management/enviro/master/bwc/types';
import { useBwcListStore } from '@/pages/case-management/enviro/master/bwc/useBwcListStore';
// 👉 Store
const bwcListStore = useBwcListStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalBwcItems = ref(0)
const bwcItems = ref<BwcProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
// 👉 Fetching bwcItems
const fetchBwcItems = () => {
  isTableLoading.value = true
  bwcListStore.fetchBwcItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    bwcItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalBwcItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(e => {
    const { message } = e.response.data;
    alertMessage.value=message
    alertType.value='error'
    isAlertVisible.value=true
  })
}

watchEffect(fetchBwcItems)

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

const isAddEditOffenceHowDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = bwcItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = bwcItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalBwcItems.value}`
})

// 👉 Add new offencehow
const addNewBwc = (offenceHowData: BwcProperties) => {
  bwcListStore.addBwc(offenceHowData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(e => {
    isAddEditOffenceHowDialogVisible.value=true
    const { message } = e.response.data;
    alertMessage.value=message
    alertType.value='error'
    isAlertVisible.value=true
  })
  // refetch User
  fetchBwcItems()
}

const updateStatusOffenceHow = (id:number  , status:string) => {
  bwcListStore.updateBwcStatus(id,status)
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
const updateBwc = (offenceHowData: BwcProperties) => {
  bwcListStore.updateBwc(offenceHowData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(e => {
    isAddEditOffenceHowDialogVisible.value=true
    const { message } = e.response.data;
    alertMessage.value=message
    alertType.value='error'
    isAlertVisible.value=true
  })
  // refetch User
  fetchBwcItems()
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
       <VCardTitle class="px-0">BWC Details </VCardTitle>
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
          <VBtn @click="selectedItem={};isAddEditOffenceHowDialogVisible = true">
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
              BWC Number 
            </th>
            <th scope="col">
              Officer/Site Name
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
            v-for="bwcItem in bwcItems"
            :key="bwcItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ bwcItem.id }}
            </td>
           <!-- 👉 Text On Machine -->
            <td>
              {{ bwcItem.bwcNumber }}
            </td> 
            <!-- 👉 Text On Letter -->
            <td>
              {{ bwcItem.name }}
            </td> 
            
            <!-- 👉 Status -->
            <td>
              
              <VSwitch
                  v-model="bwcItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusOffenceHow(bwcItem.id,bwcItem.status)"
                  
                />
            </td>

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=bwcItem;isAddEditOffenceHowDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!bwcItems.length">
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
    
    <AddEditBwcDialog
      v-model:isDialogOpen="isAddEditOffenceHowDialogVisible"
      @bwcadd-data="addNewBwc"
      @bwcupdate-data="updateBwc"
      :selected-bwc="selectedItem"
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
