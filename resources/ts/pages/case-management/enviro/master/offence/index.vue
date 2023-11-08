<script setup lang="ts">
import type { OffenceProperties } from '@/pages/case-management/enviro/master/offence/types';
import { useOffenceListStore } from '@/pages/case-management/enviro/master/offence/useOffenceListStore';
// 👉 Store
const offenceListStore = useOffenceListStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalOffenceItems = ref(0)
const offenceItems = ref<OffenceProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const isTableLoading = ref(false)

// 👉 Fetching offence items
const fetchOffenceItems = () => {
  isTableLoading.value = true
  offenceListStore.fetchOffenceItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    offenceItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalOffenceItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(e => {    
    const { message } = e.response.data;
    alertMessage.value=message
    alertType.value='error'
    isAlertVisible.value=true
  })
}

const updateStatusOffence = (id:number  , status:string) => {
  offenceListStore.updateOffenceStatus(id,status)
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

const filter = (id:number) => {
  const issueTypeList = [{id:1, name: "Penelty"}, {id:2, name: "Notice"}];
  const issueType = issueTypeList.find(site => site.id === id);
  return issueType ? issueType.name : [];
}

watchEffect(fetchOffenceItems)

// 👉 search filters
const status = [
  { title: 'All', value: '' },
  { title: 'Active', value: '1' },
  { title: 'Inactive', value: '0' },
]


// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = offenceItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = offenceItems.value.length + ((currentPage.value - 1) * rowPerPage.value);
  return `${firstIndex}-${lastIndex} of ${totalOffenceItems.value}`
})

const computedMoreList = computed(() => {
  return (paramId: number) => ([   
    { title: 'Edit', value: 'edit', prependIcon: 'mdi-pencil-outline' , to: { name: 'edit-offence', params: { id: paramId } }, },    
  ])
})

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
       <VCardTitle class="px-0">Offence(s) List </VCardTitle>
        <!-- 👉 Export button -->   
        <VSpacer />
        <div class="app-user-search-filter d-flex align-center gap-6">
          <!-- 👉 Search  -->
          <VTextField
            v-model="searchQuery"
            placeholder="Search"
            density="compact"
          />
          <!-- 👉 Add user button -->
          <VBtn :to="{ name: 'add-offence' }" >
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
            <th scope="col">
              Offence Name
            </th>
            <th scope="col">
              Offence Group
            </th>
            <th scope="col">
              Legislation (English)
            </th>
             <th scope="col">
              Legislation (Welsh)
            </th>
             <th scope="col">
              Issue Type
            </th>
            <th scope="col">
              STATUS
            </th>
            <th scope="col">
              ACTIONS
            </th>
          </tr>
        </thead>

        <!-- 👉 table body -->
        <tbody>
          <tr
            v-for="offenceItem in offenceItems"
            :key="offenceItem.id"            
          >          
            <td>
              {{ offenceItem.name }}  
            </td>          
            <td>
              {{ (offenceItem.group) ?  offenceItem.group.englishName : ''}}
            </td> 
            <td>
               {{ (offenceItem.englishLegislation) ? offenceItem.englishLegislation.title : '' }}
            </td> 
            <td>
               {{ (offenceItem.welshLegislation) ? offenceItem.welshLegislation.title : ''}}
            </td>            
            <td>
               {{ (offenceItem.issueType) ? filter(Number(offenceItem.issueType)) : '' }}
            </td>              
            <!-- 👉 Status -->
            <td>              
              <VSwitch
                  v-model="offenceItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusOffence(offenceItem.id,offenceItem.status)"                  
              />
            </td>
            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
              <MoreBtn
                :menu-list="computedMoreList(offenceItem.id)"
                item-props
              />
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!offenceItems.length">
          <tr >
            <td
              colspan="10"
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
    
    <!-- 👉 Add New User -->    
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
