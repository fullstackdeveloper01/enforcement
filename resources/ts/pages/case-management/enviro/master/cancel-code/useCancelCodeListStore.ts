import type { CancelCodeParams, CancelCodeProperties } from '@/pages/case-management/enviro/master/cancel-code/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useCancelCodeListStore = defineStore('CancelCodeListStore', {
  actions: {

    // 👉 Fetch cancelcode data
    fetchCancelCodeItems(params: CancelCodeParams) { return axios.get('/api/enviro/master/cancelcode', { params }) },

    // 👉 Add cancelcode
    addCancelCode(Data: Partial<CancelCodeProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/cancelcode', 
          Data
        )
    },

    // 👉 Update cancelcode status
   updateCancelCodeStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/cancelcode/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update cancelcode
    updateCancelCode(Data: Partial<CancelCodeProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/cancelcode/'+id, 
      Data
    )
    },
    
  },
})
