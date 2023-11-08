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
    axios.get('/api/enviro/'+route.params.id)
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
            if(data.images.length > 0)
            {
                showEnviroImages.value = true;
            }
            console.log(data)
            recordCount.value.payment_count = data.payments.length
            recordCount.value.representation_count = data.representations.length
            enviro.value = data;
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
                <h3 style="font-weight:500" v-if="showTables">
                    {{enviro.fpn_number}} - {{ enviro.offender.salutation }}. {{ enviro.offender.first_name }} {{ enviro.offender.last_name }} 
                </h3>
            </VCol>
            <VCol md="6" cols="6">
                <div v-if="showTables" class="text-right">
                    <VChip
                        color="success"
                        size="small"
                        class="text-capitalize"
                        v-if="enviro.fpn_status == 'paid'"
                    >
                        {{enviro.fpn_status.charAt(0).toUpperCase() + enviro.fpn_status.slice(1)}}
                    </VChip>

                    <VChip
                        color="info"
                        size="small"
                        class="text-capitalize"
                        v-else
                    >
                        {{enviro.fpn_status.charAt(0).toUpperCase() + enviro.fpn_status.slice(1)}}
                    </VChip>
                </div>
            </VCol>
        </VRow>
        <hr class="my-3" style="border:none;border-bottom:1px solid #f1f1f1;"/>
        <VRow>
            <VCol md="4" cols="4">
                <VTable style="text-align:left" v-if="showTables">
                    <tr>
                        <th class="pt-2">Issued at:</th>
                        <td class="pt-2">{{ enviro.issue_datetime }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Offence:</th>
                        <td class="pt-2">{{ enviro.offence.englishName }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Offence Type:</th>
                        <td class="pt-2">{{ enviro.offence_type_name }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Amount:</th>
                        <td class="pt-2">
                            <span>
                                <b>£{{ enviro.amount.amount_full }}</b>
                                <span v-if="enviro.amount.show_reduced">
                                    (£{{ enviro.amount.amount_reduced }} if paid before {{ enviro.amount.deadline }})
                                </span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="pt-2">Officer:</th>
                        <td class="pt-2">
                            {{ enviro.officer.name }}
                        </td>
                    </tr>
                    <tr v-if="enviro.signature != null" >
                        <th></th>
                        <td>
                            <img :src="`/uploads/enviro/signatures/`+enviro.signature" width="50"/>
                        </td>
                    </tr>
                    <tr>
                        <th class="pt-2">Zone/Ward:</th>
                        <td class="pt-2" v-if="enviro.zone != null">{{ enviro.zone.name }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Description:</th>
                        <td class="pt-2">
                            {{ enviro.description }}
                        </td>
                    </tr>
                </VTable>
            </VCol>
            <VCol md="4" cols="4">
                <VTable style="text-align:left" v-if="showTables">
                    <tr>
                        <th class="pt-2">Offence at:</th>
                        <td class="pt-2">{{ enviro.offence_datetime }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Address:</th>
                        <td class="pt-2">
                            {{ enviro.offender.address }}
                        </td>
                    </tr>
                    <tr>
                        <th class="pt-2">Town/Local Area:</th>
                        <td class="pt-2" v-if="enviro.area != null">{{ enviro.area.name }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Visibility:</th>
                        <td class="pt-2">{{ enviro.visibility.name }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Ethnicity:</th>
                        <td class="pt-2">
                            {{ enviro.ethnicity.name }}
                        </td>
                    </tr>
                    <tr>
                        <th class="pt-2">Language:</th>
                        <td class="pt-2">
                            {{ enviro.language }}
                        </td>
                    </tr>
                </VTable>
            </VCol>
            <VCol md="4" cols="4">
                <VTable style="text-align:left" v-if="showTables">
                    <tr>
                        <th class="pt-2">Offender Name:</th>
                        <td class="pt-2">
                            {{ enviro.offender.salutation }} {{ enviro.offender.first_name }} {{ enviro.offender.last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th class="pt-2">Gender:</th>
                        <td class="pt-2">{{ enviro.offender.gender }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">DOB:</th>
                        <td class="pt-2">{{ enviro.offender.date_of_birth }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Mobile No:</th>
                        <td class="pt-2">{{ enviro.offender.phone }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Offender Address:</th>
                        <td class="pt-2">
                            {{ enviro.offender.address }}
                        </td>
                    </tr>
                </VTable>
            </VCol>
        </VRow>
      </VCardText>
    </VCard>

    <!-- Other Details -->
    <VCard
      class="mb-6"
    >
      <VCardText>
        <VRow>
            <VCol md="12" cols="12">
                <h2 class="fw-400">Other Details</h2>
            </VCol>
        </VRow>
        <VRow>
            <VCol md="5" cols="5">
                <VTable style="text-align:left" v-if="showTables">
                    <tr>
                        <th class="pt-2">Weather:</th>
                        <td class="pt-2">{{ enviro.weather.name }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Caution:</th>
                        <td class="pt-2">{{ enviro.caution }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">2<sup>nd</sup> Caution:</th>
                        <td class="pt-2">
                            <td class="pt-2">{{ enviro.second_caution }}</td>
                        </td>
                    </tr>
                    <tr>
                        <th class="pt-2">Description of Waste:</th>
                        <td class="pt-2">{{ enviro.description_waste }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Address Verified:</th>
                        <td class="pt-2">{{ enviro.offender.verified_address }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">ID Shown:</th>
                        <td class="pt-2">
                            {{ enviro.offender.id_shown }}
                        </td>
                    </tr>
                    <tr>
                        <th class="pt-2">ID Ref. No..:</th>
                        <td class="pt-2">{{ enviro.offender.ref_no }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Barcode:</th>
                        <td class="pt-2">{{ enviro.barcode }}</td>
                    </tr>
                </VTable>
            </VCol>
            <VCol md="2" cols="2">
            </VCol>
            <VCol md="5" cols="5">
                <VTable style="text-align:left" v-if="showTables">
                    <tr>
                        <th class="pt-2">Telephone:</th>
                        <td class="pt-2">{{ enviro.offender.phone }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Type of Land:</th>
                        <td class="pt-2">
                            <span v-if="enviro.type_of_land != null">
                                {{ enviro.type_of_land.name }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="pt-2">POI Prefix:</th>
                        <td class="pt-2">
                            <span v-if="enviro.poi_prefix != null">
                                {{ enviro.poi_prefix.name }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="pt-2">Action:</th>
                        <td class="pt-2">
                            <span>
                                {{ enviro.action.name }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="pt-2">Location:</th>
                        <td class="pt-2">{{ enviro.location.name }}</td>
                    </tr>
                    <tr>
                        <th class="pt-2">Is Witness Available:</th>
                        <td class="pt-2">
                            <span v-if="enviro.is_witness_available == 1">Yes</span>
                            <span v-else>No</span>
                        </td>
                    </tr>
                    <tr>
                        <th class="pt-2">Officer Statement:</th>
                        <td class="pt-2">{{ enviro.officer_statement }}</td>
                    </tr>
                </VTable>
            </VCol>
        </VRow>
        <VRow v-if="showEnviroImages">
            <VCol md="12" cols="12">
                <h2 class="fw-400">Images</h2>
            </VCol>
            <VRow class="my-2">
                <VCol md="2" cols="6" class="my-1" v-for="(img, index) in enviro.images">
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
                                <tr v-for="(pay, index) in enviro.payments" v-bind:key="pay.id">
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
                                <tr v-for="(obj, index) in enviro.representations" v-bind:key="obj.id">
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
