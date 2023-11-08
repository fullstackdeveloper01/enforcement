import type { EthnicityParams, EthnicityProperties } from '@/pages/case-management/enviro/master/ethnicity/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useEthnicityListStore = defineStore('EthnicityListStore', {
  actions: {

    // 👉 Fetch ethnicity data
    fetchEthnicityItems(params: EthnicityParams) { return axios.get('/api/enviro/master/ethnicity', { params }) },

    // 👉 Add ethnicity
    addEthnicity(Data: Partial<EthnicityProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/ethnicity', 
          Data
        )
    },

    // 👉 Update ethnicity status
   updateEthnicityStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/ethnicity/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update ethnicity
    updateEthnicity(Data: Partial<EthnicityProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/ethnicity/'+id, 
      Data
    )
    },
    
  },
})
