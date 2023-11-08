import type { OffenderBuildParams, OffenderBuildProperties } from '@/pages/case-management/enviro/master/offender-build/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useOffenderBuildListStore = defineStore('OffenderBuildListStore', {
  actions: {

    // 👉 Fetch offenderbuild data
    fetchOffenderBuildItems(params: OffenderBuildParams) { return axios.get('/api/enviro/master/offenderbuild', { params }) },

    // 👉 Add offenderbuild
    addOffenderBuild(Data: Partial<OffenderBuildProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/offenderbuild', 
          Data
        )
    },

    // 👉 Update offenderbuild status
   updateOffenderBuildStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/offenderbuild/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update offenderbuild
    updateOffenderBuild(Data: Partial<OffenderBuildProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/offenderbuild/'+id, 
      Data
    )
    },
    
  },
})
