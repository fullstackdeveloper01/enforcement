import type { OffenceLocationSuffixParams, OffenceLocationSuffixProperties } from '@/pages/case-management/enviro/master/offence-location-suffix/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useOffenceLocationSuffixListStore = defineStore('OffenceLocationSuffixListStore', {
  actions: {

    // 👉 Fetch offencelocationsuffix data
    fetchOffenceLocationSuffixItems(params: OffenceLocationSuffixParams) { return axios.get('/api/enviro/master/offencelocationsuffix', { params }) },

    // 👉 Add offencelocationsuffix
    addOffenceLocationSuffix(Data: Partial<OffenceLocationSuffixProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/offencelocationsuffix', 
          Data
        )
    },

    // 👉 Update offencelocationsuffix status
   updateOffenceLocationSuffixStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/offencelocationsuffix/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update offencelocationsuffix
    updateOffenceLocationSuffix(Data: Partial<OffenceLocationSuffixProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/offencelocationsuffix/'+id, 
      Data
    )
    },
    
  },
})
