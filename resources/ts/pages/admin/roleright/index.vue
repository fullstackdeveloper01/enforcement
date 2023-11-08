<script setup lang="ts">
import { useRoleStore } from '@/pages/admin/role/RoleStore';
import { useRoleRightStore } from '@/pages/admin/roleright/RoleRightStore';
import type { RoleRightProperties } from '@/pages/admin/roleright/types';

// 👉 Store
const roleStore = useRoleStore()
const roleRightStore = useRoleRightStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalRoleItems = ref(0)
const roleItems = ref<RoleRightProperties[]>([])
const isAlertVisible = ref(false)
const alertType = ref()
const alertMessage = ref()
const selectedItem = ref()
const isTableLoading = ref(false)
const selectedRole = ref()
const roleList = ref([]);


// 👉 Get user data from local storage
const userData = JSON.parse(localStorage.getItem('userData') || 'null')


// 👉 Fetching roles
const fetchRoles = async () => {
    try {
        const response = await roleStore.listRole({ status: '1' })
        roleList.value = response.data.data
        console.log(roleList);

    } catch (error) {
        console.error(error)
    }
}

// 👉 Fetching role rights

const listRoleRights = () => {
    isTableLoading.value = true
    roleRightStore.listRoleRights({
        q:searchQuery.value,
        perPage: rowPerPage.value,
        currentPage: currentPage.value,
        status: selectedStatus.value,
        role: selectedRole.value ?? userData.role.id,
    }, selectedRole.value ?? userData.role.id).then(response => {
        roleItems.value = response.data.data
        totalPage.value = response.data.last_page
        totalRoleItems.value = response.data.total ?? 1
        isTableLoading.value = false
    }).catch(error => {
        console.error(error)
    })
}

// 👉 Update permission of the Role
const updatePermissionRole = (role: string, permission:string, permissionStatus: boolean) => {
  roleRightStore.updatePermissionRole(role, permission, permissionStatus)
    .then(response => {
        console.log(response)
      alertMessage.value = response.data.message
      alertType.value = 'success'
      isAlertVisible.value = true
    }).catch(error => {
      console.error(error)
    })
}

onMounted(async () => {
  await fetchRoles()
})
watchEffect(listRoleRights)
watchEffect(fetchRoles)

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


const status = [
    { title: 'All', value: '' },
    { title: 'Active', value: '1' },
    { title: 'Inactive', value: '0' },
]




</script>

<template>
    <section>
        <VCard title="Search Filters" class="mb-6">
            <VCardText>
                <VRow>
                    <!-- 👉 Select Role -->
                    <VCol cols="12" sm="4">
                        <VSelect v-model="selectedRole" label="Select Role" :items="roleList" item-title="name"
                            item-value="id" />
                    </VCol>
                    <!-- 👉 Select Status -->
                    <VCol cols="12" sm="4">
                        <VSelect v-model="selectedStatus" label="Select Status" :items="status" clear-icon="mdi-close" />
                    </VCol>
                </VRow>
            </VCardText>
        </VCard>
        <VCard>
            <VCardText class="d-flex flex-wrap gap-4">
                <VCardTitle class="px-0">Role Right List </VCardTitle>
                <!-- 👉 Export button -->
                <VSpacer />

            </VCardText>
            <VDivider />

            <VProgressLinear v-if="isTableLoading" indeterminate color="primary" />
            <VTable class="text-no-wrap table-header-bg rounded-0">
                <!-- 👉 table head -->
                <thead>
                    <tr>
                        <th scope="col">
                            Category
                        </th>
                        <th scope="col">
                            Manage
                        </th>
                    </tr>
                </thead>

                <!-- 👉 table body -->
                <tbody>
                    <!-- <tr>
                        <td>
                            Admin
                        </td>

                        <td class="text-center">
                            <span v-for="right in roleItems">
                                <VCheckbox v-model="right.status" :true-value="1" :false-value="0"
                                    v-if="right.category == 'Admin'" />
                            </span>
                        </td>


                    </tr> -->
                    <tr v-for="right in roleItems.permission">
                        <td >
                            {{right.category}}
                        </td>

                        <td class="text-center">
                            <span>
                                <VCheckbox v-model="right.status" @change="updatePermissionRole(roleItems.id,right.id,right.status)" :true-value="1" :false-value="0"
                                    />
                            </span>
                        </td>


                    </tr>
                    <!-- <tr>
                        <td>
                            Setup
                        </td>

                        <td class="text-center">
                            <span v-for="right in roleItems">
                                <VCheckbox v-model="right.status" :true-value="1" :false-value="0"
                                    v-if="right.category == 'Setup'" />
                            </span>
                        </td>


                    </tr>
                    <tr>
                        <td>
                            Machine Control
                        </td>

                        <td class="text-center">
                            <span v-for="right in roleItems">
                                <VCheckbox v-model="right.status" :true-value="1" :false-value="0"
                                    v-if="right.category == 'Machine Control'" />
                            </span>
                        </td>


                    </tr>
                    <tr>
                        <td>
                            Enviro Master
                        </td>

                        <td class="text-center">
                            <span v-for="right in roleItems">
                                <VCheckbox v-model="right.status" :true-value="1" :false-value="0"
                                    v-if="right.category == 'Enviro Master'" />
                            </span>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            Service Requests
                        </td>

                        <td class="text-center">
                            <span v-for="right in roleItems">
                                <VCheckbox v-model="right.status" :true-value="1" :false-value="0"
                                    v-if="right.category == 'Service Requests'" />
                            </span>
                        </td>


                    </tr>
                    <tr>
                        <td>
                            Reports
                        </td>

                        <td class="text-center">
                            <span v-for="right in roleItems">
                                <VCheckbox v-model="right.status" :true-value="1" :false-value="0"
                                    v-if="right.category == 'Reports'" />
                            </span>
                        </td>


                    </tr>
                    <tr>
                        <td>
                            Letters
                        </td>

                        <td class="text-center">
                            <span v-for="right in roleItems">
                                <VCheckbox v-model="right.status" :true-value="1" :false-value="0"
                                    v-if="right.category == 'Letters'" />
                            </span>
                        </td>

                    </tr> -->
                </tbody>

                <!-- 👉 table footer  -->

                <tfoot v-show="!Object.keys(roleItems).length">

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




        <VSnackbar v-model="isAlertVisible" transition="fade-transition" location="top center" variant="flat"
            :color="alertType">
            {{ alertMessage }}
            <template #actions>
                <VBtn color="white" @click="isAlertVisible = false">

                    Close

                </VBtn>

            </template>
        </VSnackbar>
    </section>
</template>
