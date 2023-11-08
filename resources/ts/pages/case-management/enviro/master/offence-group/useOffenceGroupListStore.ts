import type { OffenceGroupParams, OffenceGroupProperties } from '@/pages/case-management/enviro/master/offence-group/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useOffenceGroupListStore = defineStore('OffenceGroupListStore', {
  actions: {
    // 👉 Fetch offencegroup data
    fetchOffenceGroupItems(params: OffenceGroupParams) { return axios.get('/api/enviro/master/offencegroup', { params }) },

    // 👉 Add offencegroup
    addOffenceGroup(Data: Partial<OffenceGroupProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/offencegroup', 
          Data
        )
    },

    // 👉 Update offencegroup status
   updateOffenceGroupStatus(id:number,status:string) {
      return axios.put(`/api/enviro/master/offencegroup/${id}/status`, 
        {status:status}
      )
    },

    // 👉 Update offencegroup
    updateOffenceGroup(Data: Partial<OffenceGroupProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put(`/api/enviro/master/offencegroup/${id}`, 
        Data
      )
    },
    
  },
})
