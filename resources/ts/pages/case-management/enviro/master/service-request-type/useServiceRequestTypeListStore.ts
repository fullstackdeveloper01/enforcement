import type { ServiceRequestTypeParams, ServiceRequestTypeProperties } from '@/pages/case-management/enviro/master/service-request-type/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useServiceRequestTypeListStore = defineStore('ServiceRequestTypeListStore', {
  actions: {

    // 👉 Fetch servicerequesttype data 
    fetchServiceRequestTypeItems(params: ServiceRequestTypeParams) { return axios.get('/api/enviro/master/servicerequesttype', { params }) },

    // 👉 Add servicerequesttype
    addServiceRequestType(Data: Partial<ServiceRequestTypeProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/servicerequesttype', 
          Data
        )
    },

    // 👉 Update servicerequesttype status
   updateServiceRequestTypeStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/servicerequesttype/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update servicerequesttype
    updateServiceRequestType(Data: Partial<ServiceRequestTypeProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/servicerequesttype/'+id, 
      Data
    )
    },
    
  },
})

