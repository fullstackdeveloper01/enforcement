import type { RepresentationDeclineReasonParams, RepresentationDeclineReasonProperties } from '@/pages/case-management/enviro/master/representation-decline-reason/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useRepresentationDeclineReasonListStore = defineStore('RepresentationDeclineReasonListStore', {
  actions: {

    // 👉 Fetch representationdeclinereason data 
    fetchRepresentationDeclineReasonItems(params: RepresentationDeclineReasonParams) { return axios.get('/api/enviro/master/representationdeclinereason', { params }) },

    // 👉 Add representationdeclinereason
    addRepresentationDeclineReason(Data: Partial<RepresentationDeclineReasonProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/representationdeclinereason', 
          Data
        )
    },

    // 👉 Update representationdeclinereason status
   updateRepresentationDeclineReasonStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/representationdeclinereason/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update representationdeclinereason
    updateRepresentationDeclineReason(Data: Partial<RepresentationDeclineReasonProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/representationdeclinereason/'+id, 
      Data
    )
    },
    
  },
})

