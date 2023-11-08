import type { ServiceRequestReportedViaParams, ServiceRequestReportedViaProperties } from '@/pages/case-management/enviro/master/service-request-reported-via/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useServiceRequestReportedViaListStore = defineStore('ServiceRequestReportedViaListStore', {
  actions: {

    // 👉 Fetch servicerequestreportedvia data 
    fetchServiceRequestReportedViaItems(params: ServiceRequestReportedViaParams) { return axios.get('/api/enviro/master/servicerequestreportedvia', { params }) },

    // 👉 Add servicerequestreportedvia
    addServiceRequestReportedVia(Data: Partial<ServiceRequestReportedViaProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/servicerequestreportedvia', 
          Data
        )
    },

    // 👉 Update servicerequestreportedvia status
   updateServiceRequestReportedViaStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/servicerequestreportedvia/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update servicerequestreportedvia Back Office
    updateServiceRequestReportedViaBackOffice(id:number,back_office:string) {
    return axios.put('/api/enviro/master/servicerequestreportedvia/'+id+'/backoffice', 
    {is_back_office:back_office}
  )
  },

  // 👉 Update servicerequestreportedvia Online
  updateServiceRequestReportedViaOnline(id:number,online:string) {
    return axios.put('/api/enviro/master/servicerequestreportedvia/'+id+'/online', 
    {is_online:online}
  )
  },

    // 👉 Update servicerequestreportedvia
    updateServiceRequestReportedVia(Data: Partial<ServiceRequestReportedViaProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/servicerequestreportedvia/'+id, 
      Data
    )
    },
    
  },
})

