<script setup lang="ts">
import AddEditPositionOfEmploymentDialog from '@/pages/case-management/enviro/master/position-of-employment/AddEditPositionOfEmploymentDialog.vue';
import type { PositionOfEmploymentProperties } from '@/pages/case-management/enviro/master/position-of-employment/types';
import { usePositionOfEmploymentListStore } from '@/pages/case-management/enviro/master/position-of-employment/usePositionOfEmploymentListStore';
// 👉 Store
const PositionOfEmploymentListStore = usePositionOfEmploymentListStore()
const searchQuery = ref('') 
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalPositionOfEmploymentItems = ref(0)
const PositionOfEmploymentItems = ref<PositionOfEmploymentProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
// 👉 Fetching PositionOfEmploymentItems
const fetchPositionOfEmploymentItems = () => {
isTableLoading.value = true
PositionOfEmploymentListStore.fetchPositionOfEmploymentItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    PositionOfEmploymentItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalPositionOfEmploymentItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchPositionOfEmploymentItems)

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

const isAddEditPositionOfEmploymentDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = PositionOfEmploymentItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = PositionOfEmploymentItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalPositionOfEmploymentItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new offencelocationprefix
const addNewPositionOfEmployment = (PositionOfEmploymentData: PositionOfEmploymentProperties) => {
  PositionOfEmploymentListStore.addPositionOfEmployment(PositionOfEmploymentData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchPositionOfEmploymentItems()
  }).catch(error => {
    alertMessage.value= error.response.data.message;
    alertType.value='error'
    isAlertVisible.value=true
    console.error(error.response.data.message)
  })
}

const updateStatusPositionOfEmployment = (id:number  , status:string) => {
  PositionOfEmploymentListStore.updatePositionOfEmploymentStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}


const updatePositionOfEmployment = (PositionOfEmploymentData: PositionOfEmploymentProperties) => {
  PositionOfEmploymentListStore.updatePositionOfEmployment(PositionOfEmploymentData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
    // refetch User
    fetchPositionOfEmploymentItems()
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
       <VCardTitle class="px-0">Position of Employment Details </VCardTitle>
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
          <VBtn @click="selectedItem={};isAddEditPositionOfEmploymentDialogVisible = true">
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
              Position of Employment 
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
            v-for="positionOfEmploymentItem in PositionOfEmploymentItems"
            :key="positionOfEmploymentItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ positionOfEmploymentItem.id }}
            </td>

            <!-- 👉 Text On closed code type -->
            <td>
              {{ positionOfEmploymentItem.position_of_employment }}
            </td>
            
            <!-- 👉 Status -->
            <td>
              <VSwitch
                  v-model="positionOfEmploymentItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusPositionOfEmployment(positionOfEmploymentItem.id,positionOfEmploymentItem.status)"
                  
                />
            </td>

            

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=positionOfEmploymentItem;isAddEditPositionOfEmploymentDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!PositionOfEmploymentItems.length">
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
    
    <AddEditPositionOfEmploymentDialog
      v-model:isDialogOpen="isAddEditPositionOfEmploymentDialogVisible"
      @positionOfEmploymentadd-data="addNewPositionOfEmployment"
      @positionOfEmploymentupdate-data="updatePositionOfEmployment"
      :selected-positionOfEmployment="selectedItem"
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
  