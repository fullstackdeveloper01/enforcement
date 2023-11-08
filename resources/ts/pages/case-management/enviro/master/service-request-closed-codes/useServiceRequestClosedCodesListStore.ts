import type { ServiceRequestClosedCodesParams, ServiceRequestClosedCodesProperties } from '@/pages/case-management/enviro/master/service-request-closed-codes/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useServiceRequestClosedCodesListStore = defineStore('ServiceRequestClosedCodesListStore', {
  actions: {

    // 👉 Fetch servicerequestclosedcodes data 
    fetchServiceRequestClosedCodesItems(params: ServiceRequestClosedCodesParams) { return axios.get('/api/enviro/master/servicerequestclosedcodes', { params }) },

    // 👉 Add servicerequestclosedcodes
    addServiceRequestClosedCodes(Data: Partial<ServiceRequestClosedCodesProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/servicerequestclosedcodes', 
          Data
        )
    },

    // 👉 Update servicerequestclosedcodes status
   updateServiceRequestClosedCodesStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/servicerequestclosedcodes/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update servicerequestclosedcodes
    updateServiceRequestClosedCodes(Data: Partial<ServiceRequestClosedCodesProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/servicerequestclosedcodes/'+id, 
      Data
    )
    },
    
  },
})

