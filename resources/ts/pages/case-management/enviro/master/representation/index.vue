<script setup lang="ts">
import type { RepresentaionProperties, StatItemParams } from '@/pages/case-management/enviro/master/representation/types';
import { useRepresentaionListStore } from '@/pages/case-management/enviro/master/representation/useRepresentationListStore.js';
import CardStatisticsHorizontal from '@core/components/CardStatisticsHorizontal.vue';

// 👉 Store
const representaionListStore = useRepresentaionListStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const council = ref('')
const councilList = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalOffenceGroupItems = ref(0)
const representaionItems = ref<RepresentaionProperties[]>([])
const statisticsHorizontal = ref<StatItemParams[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const dateRange = ref('')
const isTableLoading = ref(false)
var totalRep = ref(0);


// 👉 Fetching representaionItems
const fetchOffenceGroupItems = () => {
  isTableLoading.value = true
  representaionListStore.fetchOffenceGroupItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    lodgeDate: dateRange.value,
    council: council.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    representaionItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalOffenceGroupItems.value = totalRep.value = response.data.pagination.total
    isTableLoading.value = false;
    councilList.value = response.data.councilList;

    statisticsHorizontal.value = [
      {
        title: 'No. Rep. Lodged',
        color: 'primary',
        icon: 'mdi-account-cash-outline',
        stats: totalRep.value,
      },
      {
        title: 'No. Rep. Approved',
        color: 'success',
        icon: 'mdi-account-clock-outline',
        stats: response.data.statusCount.open,
      },
      {
        title: 'No. Rep. Declined',
        color: 'info',
        icon: 'mdi-account-check-outline',
        stats: response.data.statusCount.declined,
      },
      {
        title: 'No. Rep. Unresolved',
        color: 'warning',
        icon: 'mdi-account-cancel-outline',
        stats: response.data.statusCount.pending,
      },
    ];
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
    currentPage.value = totalPage.value;
})

// 👉 search filters
const status = [
  { title: 'All', value: '' },
  { title: 'Open', value: 'Open' },
  { title: 'Pending', value: 'Pending' },
  { title: 'Solved', value: 'Solved' },
]

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

watchEffect(() =>{
})

const formatDate = (dateString) => {
    const date = new Date(dateString);
      return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' , hour: '2-digit', 
    minute: '2-digit',  });
}

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = representaionItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = representaionItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalOffenceGroupItems.value}`
})
</script>

<template>
  <section>
    <VRow class="match-height mb-4">
      <!-- 👉 Images Cards -->
      <VCol
        v-for="statistics in statisticsHorizontal"
        :key="statistics.title"
        cols="12"
        sm="6"
        md="3"
      >
        <CardStatisticsHorizontal v-bind="statistics" />
      </VCol>
    </VRow>
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
              v-model="council"
              label="Council Name"
              :items="councilList"  
              multiple
              persistent-hint    
          />
          </VCol>
          <VCol
            cols="12"
            sm="4"
          >
            <VSelect
              v-model="selectedStatus"
              label="Lodged Status"
              :items="status"
            
              clear-icon="mdi-close"
            />
          </VCol>
          <VCol
            cols="12"
            sm="4"
          >
            <AppDateTimePicker
              v-model="dateRange"
              label="Lodged date"
              clear-icon="mdi-close"
              clearable
              :config="{ mode: 'range' }"
            />
          </VCol>
        </VRow>
      </VCardText>
    </VCard>

    <VCard >
      <VCardText class="d-flex flex-wrap gap-4">
       <VCardTitle class="px-0">Representation Details </VCardTitle>
        <!-- 👉 Export button -->
      

        <VSpacer />

        <div class="app-user-search-filter d-flex align-center gap-6">
          <!-- 👉 Search  -->
          <VTextField
            v-model="searchQuery"
            placeholder="Search"
            density="compact"
          />
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
              FPN Number
            </th>
            <th scope="col">
              Council Name
            </th> 
            <th scope="col">
              Offence
            </th> 
            <th scope="col">
              Rep. Reason
            </th>   
            <th scope="col">
              Lodged Status
            </th>         
            <th scope="col">
              Lodged By
            </th>       
            <th scope="col">
              Lodged On
            </th>
          </tr>
        </thead>

        <!-- 👉 table body -->
        <tbody>
          <tr
            v-for="representaionItem in representaionItems"
            :key="representaionItem.id"
          >
           <!-- 👉 ID -->
            <td>
              {{ representaionItem.id }}
            </td>
           <!-- 👉 Text On Machine -->
            <td>
              <a :href="'https://nationalenforcementsolutions.zendesk.com/agent/tickets/'+representaionItem.ticket_id" target="blank">{{ representaionItem.fpn_number }}</a>
            </td> 
            <!-- 👉 Text On Letter -->
            <td>
              {{ representaionItem.site.name }}
            </td> 
            <td>
              {{ representaionItem.offence.englishName }}
            </td> 
            <td>
              {{ representaionItem.reason.reason }}
            </td>             
            <td >
              <VChip
                color="success"
                size="small"
                class="text-capitalize"
                v-if="representaionItem.lodged_status == 'Open'"
              >
                {{representaionItem.lodged_status.toUpperCase()}}
              </VChip>
              <VChip
                color="primary"
                size="small"
                class="text-capitalize"
                v-if="representaionItem.lodged_status == 'Solved'"
              >
                {{representaionItem.lodged_status.toUpperCase()}}
              </VChip>
              <VChip
                color="danger"
                size="small"
                class="text-capitalize"
                v-if="representaionItem.lodged_status == 'Pending'"
              >
                {{representaionItem.lodged_status.toUpperCase()}}
              </VChip>
            </td> 
            <td>
              {{ representaionItem.first_name }}
            </td>
            <td>
              {{ formatDate(representaionItem.created_at) }}
            </td>
          </tr>          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!representaionItems.length">
          <tr >
            <td
              colspan="8"
              class="text-center"
            >
              No matching records found.
            </td>
          </tr>
        </tfoot>
      </VTable>

      <VDivider />

      <VCardText class="d-flex align-center flex-wrap justify-end gap-4 pa-4">
        <div
          class="d-flex align-center me-3"
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
