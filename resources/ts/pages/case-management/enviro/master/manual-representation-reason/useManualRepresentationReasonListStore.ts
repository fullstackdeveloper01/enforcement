import type { ManualRepresentationReasonParams, ManualRepresentationReasonProperties } from '@/pages/case-management/enviro/master/manual-representation-reason/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useManualRepresentationReasonListStore = defineStore('ManualRepresentationReasonListStore', {
  actions: {

    // 👉 Fetch manualrepresentationreason data
    fetchManualRepresentationReasonItems(params: ManualRepresentationReasonParams) { return axios.get('/api/enviro/master/manualrepresentationreason', { params }) },

    // 👉 Add manualrepresentationreason
    addManualRepresentationReason(Data: Partial<ManualRepresentationReasonProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/manualrepresentationreason', 
          Data
        )
    },

    // 👉 Update manualrepresentationreason status
   updateManualRepresentationReasonStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/manualrepresentationreason/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update manualrepresentationreason
    updateManualRepresentationReason(Data: Partial<ManualRepresentationReasonProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/manualrepresentationreason/'+id, 
      Data
    )
    },
    
  },
})

