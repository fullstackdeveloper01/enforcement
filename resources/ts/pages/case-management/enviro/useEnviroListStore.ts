import type { EnviroParams, EnviroProperties } from '@/pages/case-management/enviro/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useEnviroListStore = defineStore('EnviroListStore', {
  actions: {

    // 👉 Fetch enviro data
    fetchEnviroItems(params: EnviroParams) { return axios.get('/api/enviro/', { params }) },
    
    // 👉 fetch single user
    fetchEnviroItem(id: number) {
    
        return axios.get(`/api/enviro/${id}`)
      
    },
    // 👉 Add enviro
    addEnviro(Data: Partial<EnviroProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/', 
          Data
        )
    },

    // 👉 Update enviro status
   updateEnviroStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/enviro/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update enviro
    updateEnviro(Data: Partial<EnviroProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/enviro/'+id, 
      Data
    )
    },
    
  },
})
