import type { ServiceRequestTaskTypeParams, ServiceRequestTaskTypeProperties } from '@/pages/case-management/enviro/master/service-request-task-type/types'
import type { SiteParams } from '@/pages/setup/sites/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useServiceRequestTaskTypeListStore = defineStore('ServiceRequestTaskTypeListStore', {
  actions: {

    // 👉 Fetch servicerequesttasktype data 
    fetchServiceRequestTaskTypeItems(params: ServiceRequestTaskTypeParams) { return axios.get('/api/enviro/master/servicerequesttasktype', { params }) },

    // 👉 Add servicerequesttasktype
    addServiceRequestTaskType(Data: Partial<ServiceRequestTaskTypeProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/servicerequesttasktype', 
          Data
        )
    },

    // 👉 Update servicerequesttasktype status
   updateServiceRequestTaskTypeStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/servicerequesttasktype/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update servicerequesttasktype
    updateServiceRequestTaskType(Data: Partial<ServiceRequestTaskTypeProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/servicerequesttasktype/'+id, 
      Data
    )
    },
    
    fetchAllTaskTypes() {
      return axios.get('/api/enviro/master/servicerequesttasktype') 
    },
  },
})

