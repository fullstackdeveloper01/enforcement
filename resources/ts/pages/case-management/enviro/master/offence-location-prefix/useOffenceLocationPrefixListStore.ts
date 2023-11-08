import type { OffenceLocationPrefixParams, OffenceLocationPrefixProperties } from '@/pages/case-management/enviro/master/offence-location-prefix/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useOffenceLocationPrefixListStore = defineStore('OffenceLocationPrefixListStore', {
  actions: {

    // 👉 Fetch offencelocationprefix data
    fetchOffenceLocationPrefixItems(params: OffenceLocationPrefixParams) { return axios.get('/api/enviro/master/offencelocationprefix', { params }) },

    // 👉 Add offencelocationprefix
    addOffenceLocationPrefix(Data: Partial<OffenceLocationPrefixProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/offencelocationprefix', 
          Data
        )
    },

    // 👉 Update offencelocationprefix status
   updateOffenceLocationPrefixStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/offencelocationprefix/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update offencelocationprefix
    updateOffenceLocationPrefix(Data: Partial<OffenceLocationPrefixProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/offencelocationprefix/'+id, 
      Data
    )
    },
    
  },
})
