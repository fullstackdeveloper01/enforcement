import type { ServiceRequestTaskGroupParams, ServiceRequestTaskGroupProperties } from '@/pages/case-management/enviro/master/service-request-task-group/types'
import type { SiteParams } from '@/pages/setup/sites/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useServiceRequestTaskGroupListStore = defineStore('ServiceRequestTaskGroupListStore', {
  actions: {

    // 👉 Fetch servicerequesttaskgroup data 
    fetchServiceRequestTaskGroupItems(params: ServiceRequestTaskGroupParams) { return axios.get('/api/enviro/master/servicerequesttaskgroup', { params }) },

    // 👉 Add servicerequesttaskgroup
    addServiceRequestTaskGroup(Data: Partial<ServiceRequestTaskGroupProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/servicerequesttaskgroup', 
          Data
        )
    },

    // 👉 Update servicerequesttaskgroup status
   updateServiceRequestTaskGroupStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/servicerequesttaskgroup/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update servicerequesttaskgroup
    updateServiceRequestTaskGroup(Data: Partial<ServiceRequestTaskGroupProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/servicerequesttaskgroup/'+id, 
      Data
    )
    },
    
    fetchSites() {
      return axios.get('/api/sites') 
    },
  },
})

