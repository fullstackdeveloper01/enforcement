import type { LegislationParams, LegislationProperties } from '@/pages/case-management/enviro/master/legislation/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useLegislationListStore = defineStore('LegislationListStore', {
  actions: {

    // 👉 Fetch legislation data
    fetchLegislationItems(params: LegislationParams) { return axios.get('/api/enviro/master/legislation', { params }) },

    // 👉 Add legislation
    addLegislation(Data: Partial<LegislationProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/legislation', 
          Data
        )
    },

    // 👉 Update legislation status
   updateLegislationStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/legislation/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update legislation
    updateLegislation(Data: Partial<LegislationProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/legislation/'+id, 
      Data
    )
    },
    
  },
})
