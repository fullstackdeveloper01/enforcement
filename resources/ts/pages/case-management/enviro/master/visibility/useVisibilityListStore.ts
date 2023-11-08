import type { VisibilityParams, VisibilityProperties } from '@/pages/case-management/enviro/master/visibility/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useVisibilityListStore = defineStore('VisibilityListStore', {
  actions: {

    // 👉 Fetch visibility data
    fetchVisibilityItems(params: VisibilityParams) { return axios.get('/api/enviro/master/visibility', { params }) },

    // 👉 Add visibility
    addVisibility(Data: Partial<VisibilityProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/visibility', 
          Data
        )
    },

    // 👉 Update visibility status
   updateVisibilityStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/visibility/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update visibility
    updateVisibility(Data: Partial<VisibilityProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/visibility/'+id, 
      Data
    )
    },
    
  },
})
