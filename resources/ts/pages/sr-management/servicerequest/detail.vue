<script setup lang="ts">
import axios from '@axios';
import { useRoute } from 'vue-router';


const route = useRoute()
const router = useRouter();

const loadings = ref<boolean[]>([]);
const isAlertVisible = ref(false)
const alertType=ref()
const alertMessage=ref()
const enviro = ref([]);
const srrequests = ref([])
const data = ref([])
const sr = ref([]);
const showTables = ref(false);
const showEnviroImages = ref(false);
const cardsToggle = ref({
    details: false,
    representation: false,
    write_off: false,
    letters: false,
    payment: false,
    notes: false
});
const recordCount = ref({
    payment_count: 0,
    representation_count: 0, 
    write_off_count: 0, 
    letter_count: 0
})

// Fetch Enviro Details
const fetchEnviroDetails = () => {
    axios.get('/api/getAllService/'+route.params.id)
    .then(response => {
        if(!response.data.success)
        {
            if(response.data.error_type == 'not_found')
            {
                router.push('/FPNList/Search');
            }else{
                alertMessage.value = response.data.message
                alertType.value='error'
                isAlertVisible.value = true
                loadings.value[0] = false;
            }
        }
        else{
            // Got the enviro details
            var data = response.data.data;
            srrequests.value = data;
            showTables.value = true;
        }
    })
}
onMounted(async () => {
  await fetchEnviroDetails()
});

watchEffect(fetchEnviroDetails)

const toggleMe = (id) => {
    if(id == 'details')
    {
        let old = cardsToggle.value.details;
        cardsToggle.value = {
            details: !old,
            representation: false,
            write_off: false,
            letters: false,
            payment: false,
            notes: false
        }
    }else if(id == 'se_representation')
    {
        let old = cardsToggle.value.representation;
        cardsToggle.value = {
            details: false,
            representation: !old,
            write_off: false,
            letters: false,
            payment: false,
            notes: false
        }
    }else if(id == 'write_off')
    {
        let old = cardsToggle.value.write_off;
        cardsToggle.value = {
            details: false,
            representation: false,
            write_off: !old,
            letters: false,
            payment: false,
            notes: false
        }
    }else if(id == 'letters')
    {
        let old = cardsToggle.value.letters;
        cardsToggle.value = {
            details: false,
            representation: false,
            write_off: false,
            letters: !old,
            payment: false,
            notes: false
        }
    }
    else if(id == 'notes')
    {
        let old = cardsToggle.value.notes;
        cardsToggle.value = {
            details: false,
            representation: false,
            write_off: false,
            letters: false,
            payment: false,
            notes: !old
        }
    }else if(id == 'payment')
    {
        let old = cardsToggle.value.payment;
        cardsToggle.value = {
            details: false,
            representation: false,
            write_off: false,
            letters: false,
            payment: !old,
            notes: false
        }
    }

}

</script>

<template>
  <section>
    
    <!-- General Details -->
    <VCard
      class="mb-6"
    >
      <VCardText>
        <VRow>
            <VCol md="12" cols="12">
                <h2 class="fw-400">General</h2>
            </VCol>
        </VRow>
        <VRow>
           
            <VCol md="6" cols="6">
                <div v-if="showTables" class="text-right">
                    <VChip
                        color="success"
                        size="small"
                        class="text-capitalize"
                        v-if="srrequests.fpn_status == 'paid'"
                    >
                     </VChip>

                    <VChip
                        color="info"
                        size="small"
                        class="text-capitalize"
                        v-else
                    >
                    </VChip>
                </div>
            </VCol>
        </VRow>
        <hr class="my-3" style="border:none;border-bottom:1px solid #f1f1f1;"/>
        <VRow v-for="srrequest in srrequests">
            <VCol md="4" cols="4">
                <VTable style="text-align:left" v-if="showTables">
                    <tr>
                        <th class="pt-2">Site Name:</th>
                        <td class="pt-2">{{srrequest.site_name}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Request Type:</th>
                        <td class="pt-2">{{srrequest.request_type_id}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Busniness Waste:</th>
                        <td class="pt-2">{{srrequest.busniness_waste_status}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Complaint Option:</th>
                        <td class="pt-2">
                            <span>
                               {{srrequest.complaint_option_status}}
                            </span>
                        </td>
                    </tr>
                     
                </VTable>
            </VCol>
          
          
        </VRow>
      </VCardText>
    </VCard>

    <!-- Complaint Details -->
    <VCard
      class="mb-6"
    >
      <VCardText>
        <VRow>
            <VCol md="12" cols="12">
                <h2 class="fw-400">Complaint Details</h2>
            </VCol>
        </VRow>
        <VRow v-for="srrequest in srrequests">
            <VCol md="5" cols="5">
                <VTable style="text-align:left" v-if="showTables">
                    <tr>
                        <th class="pt-2">Title:</th>
                        <td class="pt-2">{{srrequest.title}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Job Title:</th>
                        <td class="pt-2">{{srrequest.job_title}}</td>
                    </tr>
                     <tr>
                        <th class="pt-2"> First Name:</th>
                        <td class="pt-2">{{srrequest.first_name}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2"> Last Name:</th>
                        <td class="pt-2">{{srrequest.last_name}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Home - Telephone:</th>
                        <td class="pt-2">{{srrequest.home_telephone}}</td>
                    </tr>
                    <tr>
                       <th class="pt-2">Work - Telephone:</th>
                        <td class="pt-2">{{srrequest.work_telephone}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Address 1:</th>
                        <td class="pt-2">{{srrequest.address}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Email:</th>
                        <td class="pt-2">{{srrequest.email}}</td>
                    </tr>
                </VTable>
            </VCol>
            <VCol md="2" cols="2">
            </VCol>
           
        </VRow>
        <VRow v-if="showEnviroImages">
            <VCol md="12" cols="12">
                <h2 class="fw-400">Images</h2>
            </VCol>
            <VRow class="my-2">
                <VCol md="2" cols="6" class="my-1" v-for="(img, index) in srrequests.images">
                    <img :src="`/uploads/enviro/offences/`+img.file" width="100" class="img-fluid" />
                </VCol>
            </VRow>
        </VRow>
      </VCardText>
      
    </VCard>
    <!-- Busniness Details -->

    <VCard
      class="mb-6"
    >
      <VCardText>
        <VRow>
            <VCol md="12" cols="12">
                <h2 class="fw-400">Busniness Waste Details</h2>
            </VCol>
        </VRow>
        <VRow v-for="srrequest in srrequests">
            <VCol md="5" cols="5">
                <VTable style="text-align:left" v-if="showTables">
                    <tr>
                        <th class="pt-2">Busniness Name:</th>
                        <td class="pt-2">{{srrequest.busniness_name}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Busniness Town:</th>
                        <td class="pt-2">{{srrequest.busniness_town}}</td>
                    </tr>
                     <tr>
                        <th class="pt-2"> Busniness Address:</th>
                        <td class="pt-2">{{srrequest.busniness_address}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2"> Busniness Country:</th>
                        <td class="pt-2">{{srrequest.busniness_country}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Busniness Post Code:</th>
                        <td class="pt-2">{{srrequest.busniness_post_code}}</td>
                    </tr>
                    <tr>
                       <th class="pt-2">Address 2:</th>
                        <td class="pt-2">{{srrequest.address2}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Town:</th>
                        <td class="pt-2">{{srrequest.busniness_town}}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Complaint Country :</th>
                        <td class="pt-2">{{srrequest.complaint_country}}</td>
                    </tr>
                      <tr>
                        <th class="pt-2">Complaint Postal Code :</th>
                        <td class="pt-2">{{srrequest.complaint_postal_code}}</td>
                    </tr>
                      <tr>
                        <th class="pt-2">Gender :</th>
                        <td class="pt-2">{{srrequest.gender}}</td>
                    </tr>
                      <tr>
                        <th class="pt-2">Date Of Birth :</th>
                        <td class="pt-2">{{srrequest.date_of_birth}}</td>
                    </tr>
                      <tr>
                        <th class="pt-2">Ethnicity :</th>
                        <td class="pt-2">{{srrequest.ethnicity}}</td>
                    </tr>
                </VTable>
            </VCol>
            <VCol md="2" cols="2">
            </VCol>
           
        </VRow>
        <VRow v-if="showEnviroImages">
            <VCol md="12" cols="12">
                <h2 class="fw-400">Images</h2>
            </VCol>
            <VRow class="my-2">
                <VCol md="2" cols="6" class="my-1" v-for="(img, index) in srrequests.images">
                    <img :src="`/uploads/enviro/offences/`+img.file" width="100" class="img-fluid" />
                </VCol>
            </VRow>
        </VRow>
      </VCardText>
      
    </VCard>

    <!-- Payment Details -->
    <VCard
      class="mb-6"
    >
        <VCardText>
            <VRow>
                <VCol md="6" cols="6" class="d-flex">
                    <h2 class="fw-400">Payment Details</h2>
                    <VChip
                        color="info"
                        size="x-small"
                        class="mx-2"
                    >
                        {{ recordCount.payment_count }} Records
                    </VChip>
                </VCol>
                <VCol md="6" cols="6">
                    <div class="text-right">
                        <VIcon icon="mdi-chevron-down" @click="toggleMe('payment')"/>
                    </div>
                </VCol>
            </VRow>

            <div v-if="cardsToggle.payment">
                <VRow>
                    <VCol cols="12" md="12">
                        <VTable style="text-align:left" v-if="showTables && recordCount.payment_count > 0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Transaction ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(pay, index) in srrequests.payments" v-bind:key="pay.id">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ pay.transaction_id }}</td>
                                    <td>{{ pay.date }}</td>
                                    <td>
                                        <VChip size="x-small" color="success" v-if="pay.status == 1">Paid</VChip>
                                        <VChip size="x-small" v-else>Not Paid</VChip>
                                    </td>
                                </tr>
                            </tbody>
                        </VTable>

                        <v-alert v-else size="x-small" variant="outlined" color="info" icon="$info" title="No records found"></v-alert>
                    </VCol>
                </VRow>
            </div>
            
        </VCardText>
    </VCard>

    <!-- Representation Details -->
    <VCard
      class="mb-6"
    >
        <VCardText>
            <VRow>
                <VCol md="6" cols="6">
                    <h2 class="fw-400">Representation Details</h2>
                </VCol>
                <VCol md="6" cols="6">
                    <div class="text-right">
                        <VIcon icon="mdi-chevron-down" @click="toggleMe('se_representation')"/>
                    </div>
                </VCol>
            </VRow>

            <div v-if="cardsToggle.representation">
                <VRow>
                    <VCol cols="12" md="12">
                        <VTable style="text-align:left" v-if="showTables && recordCount.representation_count > 0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Reason</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(obj, index) in srrequests.representations" v-bind:key="obj.id">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ obj.reason }}</td>
                                    <td>{{ obj.appeal_note }}</td>
                                    <td>
                                        <VChip size="x-small" color="success" v-if="pay.status == 1">Paid</VChip>
                                        <VChip size="x-small" v-else>Not Paid</VChip>
                                    </td>
                                </tr>
                            </tbody>
                        </VTable>

                        <v-alert v-else size="x-small" variant="outlined" color="info" icon="$info" title="No records found"></v-alert>
                    </VCol>
                </VRow>
            </div>
            
        </VCardText>
    </VCard>

    <!-- Write Off Details -->
    <VCard
      class="mb-6"
    >

        <VCardText>
            <VRow>
                <VCol md="6" cols="6">
                    <h2 class="fw-400">Write Off / Cancel Details</h2>
                </VCol>
                <VCol md="6" cols="6">
                    <div class="text-right">
                        <VIcon icon="mdi-chevron-down" @click="toggleMe('write_off')"/>
                    </div>
                </VCol>
            </VRow>

            <div v-if="cardsToggle.write_off">
                <VRow>
                    <VCol cols="6" md="6">
                        write_off module
                    </VCol>
                </VRow>
            </div>
            
        </VCardText>

    </VCard>
    
    <!-- Letters Details -->
    <VCard
      class="mb-6"
    >
        <VCardText>
            <VRow>
                <VCol md="6" cols="6">
                    <h2 class="fw-400">Letters Details</h2>
                </VCol>
                <VCol md="6" cols="6">
                    <div class="text-right">
                        <VIcon icon="mdi-chevron-down" @click="toggleMe('letters')"/>
                    </div>
                </VCol>
            </VRow>

            <div v-if="cardsToggle.letters">
                <VRow>
                    <VCol cols="6" md="6">
                        Letters module
                    </VCol>
                </VRow>
            </div>
            
        </VCardText>
    </VCard>

    <!-- Notes Details -->
    <VCard
      class="mb-6"
    >
        <VCardText>
            <VRow>
                <VCol md="6" cols="6">
                    <h2 class="fw-400">Notes Details</h2>
                </VCol>
                <VCol md="6" cols="6">
                    <div class="text-right">
                        <VIcon icon="mdi-chevron-down" @click="toggleMe('notes')"/>
                    </div>
                </VCol>
            </VRow>

            <div v-if="cardsToggle.notes">
                <VRow>
                    <VCol cols="6" md="6">
                        Notes module
                    </VCol>
                </VRow>
            </div>
            
        </VCardText>
    </VCard>

 
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
.tbc th{
  text-align:left!important;
}
.fw-400{
    font-weight: 400;
}
</style>
