<script setup lang="ts">

import { siteStore } from '@/pages/setup/sites/siteStore';
import type { SiteProperties } from '@/pages/setup/sites/types';

// 👉 Store
const siteListStore = siteStore()
// const roleStore = useRoleStore()
const searchQuery = ref('')
const selectedStatus = ref('')
// const selectedRole = ref()
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalsiteItems = ref(0)
const siteItems = ref<SiteProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
// const selectedItem=ref()
const isTableLoading = ref(false)
// const roleList = ref([]);

// 👉 Fetching user items
const fetchSiteItems = async () => {

  isTableLoading.value = true

  try {
    const response = await siteListStore.fetchSites({
      q: searchQuery.value,
      status: selectedStatus.value,
      perPage: rowPerPage.value,
      currentPage: currentPage.value,
    });
    
    siteItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalsiteItems.value = response.data.pagination.total

  } catch (error) {
    console.error(error)
  }
  isTableLoading.value = false
}
onMounted(async () => {
  // await fetchRoles()
  await fetchSiteItems()
});

watchEffect(fetchSiteItems)
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

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = siteItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = siteItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalsiteItems.value}`
})

const computedMoreList = computed(() => {
  return (paramId: number) => ([
    { title: 'Edit', value: 'edit', prependIcon: 'mdi-pencil-outline' , to: { name: 'edit-site', params: { id: paramId } } },
    
  ])
});

const handleToggle = async (id:number  , status:string) => {

  const token = JSON.parse(localStorage.getItem('accessToken'))

  var raw = JSON.stringify({
    "id": id
  });
  
  var myHeaders = new Headers();
  myHeaders.append(
    "Authorization", "Bearer "+token)
  var requestOptions = {
    method: 'GET',
    headers: myHeaders,
    redirect: 'follow',
  };

  fetch(window.location.origin+"/api/site/"+id+"/status", requestOptions)
  .then(response => response.json())
  .then((response) => {
    alertMessage.value=response.message
    alertType.value='success'
    isAlertVisible.value=true
  })
  .catch(error => console.log('error', error));
  
}

</script>

<template>
  <section>
  
    <VCard >
      <VCardText class="d-flex flex-wrap gap-4">
       <VCardTitle class="px-0">Site(s) List </VCardTitle>
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
          
          <VBtn :to="{ name: 'add-site' }" >
            Add Site
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
             Name
            </th>
            <th scope="col">
              Slug
            </th>
            <th scope="col">
              Geo Color
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
            v-for="siteItem in siteItems"
            :key="siteItem.id"
            
          >
          
            <td>
              {{ siteItem.name }}
            </td>
            <td>
              <a :href="`https://paymyfpn.co.uk/FPN/`+siteItem.slug" target="_blank">
                /{{ siteItem.slug }}
              </a>
            </td>
            <td>
              <div v-if="siteItem.geo_color !== null" :style="'width:25px;height:25px;background:'+siteItem.geo_color+';border-radius:30px'"></div>
            </td>
            <td>
              <v-switch v-model="siteItem.status" :model-value="siteItem.status" @change="handleToggle(siteItem.id, siteItem.status)"></v-switch>
            </td>
            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <td
              class="text-center"
              style="width: 5rem;"
            >
              <MoreBtn
                :menu-list="computedMoreList(siteItem.id)"
                item-props
              />
            </td>
           
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!siteItems.length">
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
