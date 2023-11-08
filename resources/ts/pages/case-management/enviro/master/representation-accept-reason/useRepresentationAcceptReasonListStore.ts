import type { RepresentationAcceptReasonParams, RepresentationAcceptReasonProperties } from '@/pages/case-management/enviro/master/representation-accept-reason/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useRepresentationAcceptReasonListStore = defineStore('RepresentationAcceptReasonListStore', {
  actions: {

    // 👉 Fetch representationacceptreason data 
    fetchRepresentationAcceptReasonItems(params: RepresentationAcceptReasonParams) { return axios.get('/api/enviro/master/representationacceptreason', { params }) },

    // 👉 Add representationacceptreason
    addRepresentationAcceptReason(Data: Partial<RepresentationAcceptReasonProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/representationacceptreason', 
          Data
        )
    },

    // 👉 Update representationacceptreason status
   updateRepresentationAcceptReasonStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/representationacceptreason/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update representationacceptreason
    updateRepresentationAcceptReason(Data: Partial<RepresentationAcceptReasonProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/representationacceptreason/'+id, 
      Data
    )
    },
    
  },
})

