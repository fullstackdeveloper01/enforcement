<script setup lang="ts">
import AddEditRoleDialog from '@/pages/admin/role/AddEditRoleDialog.vue';
import { useRoleStore } from '@/pages/admin/role/RoleStore';
import type { RoleProperties } from '@/pages/admin/role/types';


// 👉 Store
const roleStore = useRoleStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalRoleItems = ref(0)
const roleItems = ref<RoleProperties[]>([])
const isAlertVisible = ref(false)
const alertType = ref()
const alertMessage = ref()
const selectedItem = ref()
const isTableLoading = ref(false)

// 👉 Fetching role list
const listRole = () => {
  isTableLoading.value = true
  roleStore.listRole({
    q: searchQuery.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    roleItems.value = response.data.data
    totalPage.value = response.data.last_page
    totalRoleItems.value = response.data.data.length 
    isTableLoading.value = false
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(listRole)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = roleItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = roleItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalRoleItems.value}`
})


const isAddEditRoleDialogVisible = ref(false)

// 👉 Add new Role
const addRole = (roleData: RoleProperties) => {
  roleStore.addRole(roleData).then(response => {
    alertMessage.value = response.data.message
    alertType.value = 'success'
    isAlertVisible.value = true
  }).catch(error => {
    console.error(error)
  })
  // refetch ROle
  listRole()
}

// 👉 Update Role
const updateRole = (roleData: RoleProperties) => {
  roleStore.updateRole(roleData).then(response => {
    alertMessage.value = response.data.message
    alertType.value = 'success'
    isAlertVisible.value = true
  }).catch(error => {
    console.error(error)
  })
  // refetch Role
  listRole()
}

// 👉 Update status of the Role
const updateStatusRole = (id: number, status: string) => {
  roleStore.updateRoleStatus(id, status)
    .then(response => {
      alertMessage.value = response.data.message
      alertType.value = 'success'
      isAlertVisible.value = true
    }).catch(error => {
      console.error(error)
    })
}

</script>

<template>

  <section>
    <VCard>
      <VCardText class="d-flex flex-wrap gap-4">
        <VCardTitle class="px-0">Role List </VCardTitle>
        <!-- 👉 Export button -->


        <VSpacer />

        <div class="app-user-search-filter d-flex align-center gap-6">
          <!-- 👉 Search  -->
          <VTextField v-model="searchQuery" placeholder="Search" density="compact" />

          <!-- 👉 Add ethnicity button -->
          <VBtn @click="selectedItem = {}; isAddEditRoleDialogVisible = true">
            Add Role
          </VBtn>
        </div>
      </VCardText>

      <VDivider />

      <VProgressLinear v-if="isTableLoading" indeterminate color="primary" />

      <VTable class="text-no-wrap table-header-bg rounded-0">
        <!-- 👉 table head -->
        <thead>
          <tr>
            <th scope="col" style="width: 3rem;">
              S.No
            </th>
            <th scope="col">
              Role name
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

          <tr v-for="roleItem in roleItems" :key="roleItem.id">

            <!-- 👉 ID -->
            <td>
              {{ roleItem.id }}
            </td>
            <!-- 👉 Text On Machine -->
            <td>
              {{ roleItem.name }}
            </td>
            <!-- 👉 Status -->
            <td>             

              <VSwitch v-model="roleItem.status" :true-value="1" :false-value="0"
                @change="updateStatusRole(roleItem.id, roleItem.status)" />

            </td>

            <!-- 👉 Actions -->
            <td class="text-center" style="width: 5rem;">
              <IconBtn @click="selectedItem =roleItem;isAddEditRoleDialogVisible = true">

                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>

        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!roleItems.length">

          <tr>
            <td colspan="5" class="text-center">
              No matching records found.
            </td>
          </tr>
        </tfoot>
      </VTable>

      <VDivider />

      <VCardText class="d-flex align-center flex-wrap justify-end gap-4 pa-2">
        <div class="d-flex align-center me-3" style="width: 171px;">
          <span class="text-no-wrap me-3">Rows per page:</span>
          <VSelect v-model="rowPerPage" density="compact" variant="plain" class="mt-n4"
            :items="[25, 50, 100, 200, 500]" />

        </div>

        <div class="d-flex align-center">
          <h6 class="text-sm font-weight-regular">
            {{ paginationData }}
          </h6>

          <VPagination v-model="currentPage" size="small" :total-visible="1" :length="totalPage" />

        </div>
      </VCardText>
    </VCard>

    <!-- 👉 Add/Update New Role -->

    <AddEditRoleDialog v-model:isDialogOpen="isAddEditRoleDialogVisible" @roleAdd-data="addRole"
      @roleUpdate-data="updateRole" :selected-role="selectedItem" />

    <VSnackbar v-model="isAlertVisible" transition="fade-transition" location="top center" variant="flat"
      :color="alertType">
      {{alertMessage}}
      <template #actions>
        <VBtn color="white" @click="isAlertVisible = false">

          Close

        </VBtn>

      </template>
    </VSnackbar>
  </section>
</template>
