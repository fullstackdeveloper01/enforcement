import type { RegionParams, RegionProperties } from '@/pages/case-management/enviro/master/region/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useRegionListStore = defineStore('RegionListStore', {
  actions: {

    // 👉 Fetch region data
    fetchRegionItems(params: RegionParams) { return axios.get('/api/enviro/master/region', { params }) },

    // 👉 Add region
    addRegion(Data: Partial<RegionProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/region', 
          Data
        )
    },

    // 👉 Update region status
   updateRegionStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/region/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update region
    updateRegion(Data: Partial<RegionProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/region/'+id, 
      Data
    )
    },
    
  },
})
