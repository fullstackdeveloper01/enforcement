import type { WasteTypeParams, WasteTypeProperties } from '@/pages/case-management/enviro/master/waste-type/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useWasteTypeListStore = defineStore('WasteTypeListStore', {
  actions: {

    // 👉 Fetch waste type data 
    fetchWasteTypeItems(params: WasteTypeParams) { return axios.get('/api/enviro/master/wastetype', { params }) },

    // 👉 Add waste type
    addWasteType(Data: Partial<WasteTypeProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/wastetype', 
          Data
        )
    },

    // 👉 Update waste type status
   updateWasteTypeStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/wastetype/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update waste type
    updateWasteType(Data: Partial<WasteTypeProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/wastetype/'+id, 
      Data
    )
    },
    
  },
})

