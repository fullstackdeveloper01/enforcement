<script setup lang="ts">

import { useOrganizationStore } from '@/pages/admin/organization/organizationStore';
import type { OrganizationProperties } from '@/pages/admin/organization/types';
import avatar1 from '@images/avatars/avatar-1.png';

// 👉 Store
const orgnizationStore = useOrganizationStore()
const organizationDetail = ref<OrganizationProperties[]>([])

// 👉 Fetching organization detail
const listRole = () => {
    orgnizationStore.getOrganizationDetail().then(response => {
    console.log(response.data.data)
    organizationDetail.value = response.data.data
   
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(listRole)




</script>


<template>
    <VRow>
        <!-- SECTION User Details -->
        <VCol cols="12">



            <VCard v-for="organizationDetails in organizationDetail" :key="organizationDetails.id">
                <VCardText class="text-center pt-15"  >
                    <!-- 👉 Avatar -->
                    <VAvatar rounded :size="120" color="primary" variant="tonal">
                        <VImg :src="avatar1" />

                    </VAvatar>



                    <!-- 👉 User fullName -->
                    <h6 class="text-h6 mt-4">
                        <!-- Selina Kyle -->
                        {{ organizationDetails.name }}

                    </h6>

                    <!-- 👉 Role chip -->
                    <VChip size="small" class="text-capitalize mt-4">
                        {{ organizationDetails.address }}
                    </VChip>
                </VCardText>

                <!-- 👉 Details -->
                <VCardText>
                    <h6 class="text-h6">
                        Details
                    </h6>

                    <VDivider class="mt-4" />

                    <!-- 👉 User Details list -->
                    <VList class="card-list mt-2">
                        <VListItem>
                            <VListItemTitle class="text-sm">
                                <span class="font-weight-medium">Username:</span>
                                <span class="text-body-2">
                                    {{ organizationDetails.email }}
                                </span>
                            </VListItemTitle>
                        </VListItem>
                        <VListItem>
                            <VListItemTitle class="text-sm">
                                <span class="font-weight-medium">
                                    Status:
                                </span>
                                <VChip label size="small" class="text-capitalize">
                                    {{ organizationDetails.status == true ? 'Active' : 'Inactive' }}
                                </VChip>
                            </VListItemTitle>
                        </VListItem>
                       
                        <VListItem>
                            <VListItemTitle class="text-sm">
                                <span class="font-weight-medium">
                                    Contact:
                                </span>
                                <span class="text-body-2">  {{ organizationDetails.telephone }}</span>
                            </VListItemTitle>
                        </VListItem>
                    </VList>
                </VCardText>
            </VCard>
        </VCol>
        <!-- !SECTION -->


    </VRow>
</template>

<style lang="scss" scoped>
.card-list {
    --v-card-list-gap: 0.8rem;
}

.current-plan {
    border: 2px solid rgb(var(--v-theme-primary));
}

.text-capitalize {
    text-transform: capitalize !important;
}
</style>
