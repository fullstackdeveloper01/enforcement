import type { BwcParams, BwcProperties } from '@/pages/case-management/enviro/master/bwc/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useBwcListStore = defineStore('BwcListStore', {
  actions: {

    // 👉 Fetch bwc data
    fetchBwcItems(params: BwcParams) { return axios.get('/api/enviro/master/bwc', { params }) },

    // 👉 Add bwc
    addBwc(Data: Partial<BwcProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/bwc', 
          Data
        )
    },

    // 👉 Update bwc status
   updateBwcStatus(id:number,status:string) {
      return axios.put(`/api/enviro/master/bwc/${id}/status`, 
        {status:status}
      )
    },

    // 👉 Update bwc
    updateBwc(Data: Partial<BwcProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put(`/api/enviro/master/bwc/${id}`, 
        Data
      )
    },
    
  },
})
