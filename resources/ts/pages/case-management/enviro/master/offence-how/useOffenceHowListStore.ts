import type { OffenceHowParams, OffenceHowProperties } from '@/pages/case-management/enviro/master/offence-how/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useOffenceHowListStore = defineStore('OffenceHowListStore', {
  actions: {

    // 👉 Fetch offencehow data
    fetchOffenceHowItems(params: OffenceHowParams) { return axios.get('/api/enviro/master/offencehow', { params }) },

    // 👉 Add offencehow
    addOffenceHow(Data: Partial<OffenceHowProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/offencehow', 
          Data
        )
    },

    // 👉 Update offencehow status
   updateOffenceHowStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/offencehow/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update offencehow
    updateOffenceHow(Data: Partial<OffenceHowProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/offencehow/'+id, 
      Data
    )
    },
    
  },
})
