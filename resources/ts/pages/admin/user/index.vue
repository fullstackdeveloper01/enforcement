<script setup lang="ts">

import { useRoleStore } from '@/pages/admin/role/RoleStore';
import type { UserParams, UserProperties } from '@/pages/admin/user/types';
import { useUserListStore } from '@/pages/admin/user/useUserListStore';
import axios from '@axios';
import { avatarText } from '@core/utils/formatters';
// 👉 Store
const roleStore = useRoleStore()
const userListStore = useUserListStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const selectedRole = ref()
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalUserItems = ref(0)
const userItems = ref<UserProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
const roleList = ref([]);
// 👉 Fetching roles
const fetchRoles = async () => {
  try {
    const response = await roleStore.listRole({ status: '1' })
    roleList.value = response.data.data
  } catch (error) {
    console.error(error)
  }
}
// 👉 Fetching user items
const fetchUserItemsAPI = (params: UserParams) => { return axios.get('/api/user', { params }) };
const fetchUserItems = async () => {
  isTableLoading.value = true
  try {
    const response = await fetchUserItemsAPI({
      q: searchQuery.value,
      status: selectedStatus.value,
      role: selectedRole.value,
      perPage: rowPerPage.value,
      currentPage: currentPage.value,
    })
    userItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalUserItems.value = response.data.pagination.total
  } catch (error) {
    console.error(error)
  }
  isTableLoading.value = false
}
onMounted(async () => {
  await fetchRoles()
  await fetchUserItems()
})

watchEffect(fetchUserItems)
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


// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = userItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = userItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalUserItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new user
const addNewUser = (userData: UserProperties) => {
  userListStore.addUser(userData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
  // refetch User
  fetchUserItems()
}

const updateStatusUser = (id:number  , status:string) => {
  userListStore.updateUserStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}
const updateUser = (userData: UserProperties) => {
  userListStore.updateUser(userData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
  // refetch User
  fetchUserItems()
}
const computedMoreList = computed(() => {
  return (paramId: number) => ([
   
    { title: 'Edit', value: 'edit', prependIcon: 'mdi-pencil-outline' , to: { name: 'edit-user', params: { id: paramId } }, },
    
  ])
})
const resolveUserStatusVariant = (stat: string) => {
  const statLowerCase = stat.toLowerCase()
  if (statLowerCase === '1')
    return 'success'
  if (statLowerCase === '0')
    return 'secondary'
  return 'primary'
}
const fetchStatus = (value) => {
  const site = status.find(site => site.value === value);
  return site ? site.title : null;
}

const fetchRole = (value) => {

  const site = roleList.value.find(site => site.id === value);
  return site ? site.name : null;
 
}

const resolveUserRoleVariant = (role: number) => {
  const roleName = fetchRole(role)

  if (roleName === 'client')
    return { color: 'primary', icon: 'mdi-account-outline' }
  if (roleName === 'super admin')
    return { color: 'warning', icon: 'mdi-cog-outline' }
  if (roleName === 'ops support')
    return { color: 'success', icon: 'mdi-chart-donut' }
  if (roleName === 'admin')
    return { color: 'error', icon: 'mdi-laptop' }

  return { color: 'primary', icon: 'mdi-account-outline' }
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
         <!-- 👉 Select Role -->
        <VCol
            cols="12"
            sm="4"
          >
            <VSelect
              v-model="selectedRole"
              label="Select Role"
              :items="roleList"
              item-title="name"
              item-value="id"
            />
          </VCol>
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
       <VCardTitle class="px-0">User(s) List </VCardTitle>
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
          
          <VBtn :to="{ name: 'add-user' }" >
            Add User
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
             User Name
            </th>
            <th scope="col">
              Email
            </th>
            <th scope="col">
              Role
            </th>
             <th scope="col">
              Operator No.
            </th>
             <th scope="col">
              Pin No.
            </th>
             
            <th scope="col">
              NI Number
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
            v-for="userItem in userItems"
            :key="userItem.id"
            
          >
          
            <td>
            <div class="d-flex align-center">
                <VAvatar
                  variant="tonal"
                  
                  class="me-3"
                  size="34"
                >
                  
                  <span
                    
                    class="text-sm"
                  >{{ avatarText(userItem.name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-sm">
                    <RouterLink
                      :to="{ name: 'edit-user', params: { id: userItem.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ userItem.name }}
                    </RouterLink>
                  </h6>
                  <span class="text-xs">@{{ userItem.email }}</span>
                </div>
              </div>
            
            </td>
          
            <td>
              {{ userItem.email }}
            </td> 
           
           <td>
           <VIcon
                :icon="resolveUserRoleVariant(userItem.role.id).icon"
                :color="resolveUserRoleVariant(userItem.role.id).color"
                :size="22"
                class="me-3"
              />
              <span class="text-capitalize text-base"> {{ fetchRole(userItem.role.id)}}</span>
              
            </td> 
            <td>
               {{ userItem.operator_number }}
            </td> 
            <td>
               {{ userItem.pin_number }}
            </td> 
           
             <td>
               {{ userItem.ni_number }}
            </td> 
             <!-- 👉 Status -->
            <td>
              <VChip
                :color="resolveUserStatusVariant(userItem.status)"
                size="small"
                class="text-capitalize"
              >
                {{fetchStatus(userItem.status)}}
              </VChip>
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
                :menu-list="computedMoreList(userItem.id)"
                item-props
              />
            </td>
           
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!userItems.length">
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
