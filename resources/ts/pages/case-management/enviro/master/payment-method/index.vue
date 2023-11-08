<script setup lang="ts">
import AddEditPaymentMethodDialog from '@/pages/case-management/enviro/master/payment-method/AddEditPaymentMethodDialog.vue';
import type { PaymentMethodProperties } from '@/pages/case-management/enviro/master/payment-method/types';
import { usePaymentMethodListStore } from '@/pages/case-management/enviro/master/payment-method/usePaymentMethodListStore';
// 👉 Store
const paymentMethodListStore = usePaymentMethodListStore()
const searchQuery = ref('')
const selectedStatus = ref('')
const rowPerPage = ref(25)
const currentPage = ref(1)
const totalPage = ref(1)
const totalPaymentMethodItems = ref(0)
const paymentMethodItems = ref<PaymentMethodProperties[]>([])
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const selectedItem=ref()
const isTableLoading = ref(false)
// 👉 Fetching paymentmethoditems
const fetchPaymentMethodItems = () => {
isTableLoading.value = true
  paymentMethodListStore.fetchPaymentMethodItems({
    q: searchQuery.value,
    status: selectedStatus.value,
    perPage: rowPerPage.value,
    currentPage: currentPage.value,
  }).then(response => {
    paymentMethodItems.value = response.data.data
    totalPage.value = response.data.pagination.last_page
    totalPaymentMethodItems.value = response.data.pagination.total
    isTableLoading.value = false
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchPaymentMethodItems)

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

const isAddEditPaymentMethodDialogVisible = ref(false)

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = paymentMethodItems.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
  const lastIndex = paymentMethodItems.value.length + ((currentPage.value - 1) * rowPerPage.value)

  return `${firstIndex}-${lastIndex} of ${totalPaymentMethodItems.value}`
})


// !SECTION checkbox toggle

// 👉 Add new paymentmethod
const addNewPaymentMethod = (paymentMethodData: PaymentMethodProperties) => {
  paymentMethodListStore.addPaymentMethod(paymentMethodData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
  // refetch User
  fetchPaymentMethodItems()
}

const updateStatusPaymentMethod = (id:number  , status:string) => {
  paymentMethodListStore.updatePaymentMethodStatus(id,status)
  .then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
}
const updatePaymentMethod = (paymentMethodData: PaymentMethodProperties) => {
  paymentMethodListStore.updatePaymentMethod(paymentMethodData).then(response => {
    alertMessage.value=response.data.message
    alertType.value='success'
    isAlertVisible.value=true
  }).catch(error => {
    console.error(error)
  })
  // refetch User
  fetchPaymentMethodItems()
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
       <VCardTitle class="px-0">Payment Method(s) List </VCardTitle>
        <!-- 👉 Export button -->
      

        <VSpacer />

        <div class="app-user-search-filter d-flex align-center gap-6">
          <!-- 👉 Search  -->
          <VTextField
            v-model="searchQuery"
            placeholder="Search"
            density="compact"
          />

          <!-- 👉 Add paymentmethod button -->
          <VBtn @click="selectedItem={};isAddEditPaymentMethodDialogVisible = true">
            Add Payment Method
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
              Payment Method
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
            v-for="paymentMethodItem in paymentMethodItems"
            :key="paymentMethodItem.id"
            
          >
           <!-- 👉 ID -->
            <td>
              {{ paymentMethodItem.id }}
            </td>
           <!-- 👉 Payment Method -->
            <td>
              {{ paymentMethodItem.paymentMethod }}
            </td> 
            
            
            <!-- 👉 Status -->
            <td>
              
              <VSwitch
                  v-model="paymentMethodItem.status"
                  true-value="1"
                  false-value="0"
                  @change="updateStatusPaymentMethod(paymentMethodItem.id,paymentMethodItem.status)"
                  
                />
            </td>

            <!-- 👉 Actions -->
            <td
              class="text-center"
              style="width: 5rem;"
            >
            <IconBtn @click="selectedItem=paymentMethodItem;isAddEditPaymentMethodDialogVisible = true">
                <VIcon icon="mdi-pencil-outline" />
              </IconBtn>
            </td>
          </tr>
          
        </tbody>

        <!-- 👉 table footer  -->
        <tfoot v-show="!paymentMethodItems.length">
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

    <!-- 👉 Add New Payment Method -->
    
    <AddEditPaymentMethodDialog
      v-model:isDialogOpen="isAddEditPaymentMethodDialogVisible"
      @paymentmethodadd-data="addNewPaymentMethod"
      @paymentmethodupdate-data="updatePaymentMethod"
      :selected-paymentmethod="selectedItem"
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
