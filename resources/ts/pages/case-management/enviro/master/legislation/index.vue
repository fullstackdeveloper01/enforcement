<script setup lang="ts">
import AddEditLegislationDialog from '@/pages/case-management/enviro/master/legislation/AddEditLegislationDialog.vue';
import type { LegislationProperties } from '@/pages/case-management/enviro/master/legislation/types';
import { useLegislationListStore } from '@/pages/case-management/enviro/master/legislation/useLegislationListStore';
// 👉 Store
const legislationListStore = useLegislationListStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalLegislationItems = ref(0)
const legislationItems = ref<LegislationProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
// 👉 Fetching legislationitems
const fetchLegislationItems = () => {
isTableLoading.value = true
  legislationListStore.fetchLegislationItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    legislationItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalLegislationItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchLegislationItems)

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

const isAddEditLegislationDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = legislationItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = legislationItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalLegislationItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new legislation
const addNewLegislation = (legislationData: LegislationProperties) => {
  legislationListStore.addLegislation(legislationData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
  // refetch User
  fetchLegislationItems()
}

const updateStatusLegislation = (id:number  , status:string) => {
  legislationListStore.updateLegislationStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}
const updateLegislation = (legislationData: LegislationProperties) => {
  legislationListStore.updateLegislation(legislationData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
  // refetch User
  fetchLegislationItems()
}
const languageList = [
  { name: "Welsh", key: 'welsh' },
  { name: "English", key: 'english' },
];
const fetchLanguageName = (key) => {
  const data = languageList.find(site => site.key === key);
  return data ? data.name : null;
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
       <VCardTitle class="px-0">Legislation(s) List </VCardTitle>
        <!-- 👉 Export button -->
      

        <VSpacer />

        <div class="app-user-search-filter d-flex align-center gap-6">
          <!-- 👉 Search  -->
          <VTextField
            v-model="searchQuery"
            placeholder="Search"
            density="compact"
          />

          <!-- 👉 Add legislation button -->
          <VBtn @click="selectedItem={};isAddEditLegislationDialogVisible = true">
            Add Legislation
          </VBtn>
        </div>
      </VCardText>

      <VDivider />
<VProgressLinear
v-if="isTableLoading"
    indeterminate
    color="primary"
  />
      <VTable class="text-wrap table-header-bg rounded-0">
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
              Title 
            </th>
            <th scope="col">
              Legislation
            </th>
            <th scope="col">
              Language
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
            v-for="legislationItem in legislationItems"
            :key="legislationItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ legislationItem.id }}
            </td>
           <!-- 👉 Title -->
            <td>
              {{ legislationItem.title }}
            </td> 
            <!-- 👉 Legislation -->
            <td>
              {{ legislationItem.legislation }}
            </td> 
            <!-- 👉 Language -->
            <td>
            {{fetchLanguageName(legislationItem.language)}}
            </td>
            <!-- 👉 Status -->
            <td>
              
              <VSwitch
                  v-model="legislationItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusLegislation(legislationItem.id,legislationItem.status)"
                  
                />
            </td>

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=legislationItem;isAddEditLegislationDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!legislationItems.length">
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

    <!-- 👉 Add New Legislation -->
    
    <AddEditLegislationDialog
      v-model:isDialogOpen="isAddEditLegislationDialogVisible"
      @legislationadd-data="addNewLegislation"
      @legislationupdate-data="updateLegislation"
      :selected-legislation="selectedItem"
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
