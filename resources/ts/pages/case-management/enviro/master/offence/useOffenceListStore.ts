import type { OffenceParams, OffenceProperties } from '@/pages/case-management/enviro/master/offence/types';
import axios from '@axios';
import { defineStore } from 'pinia';

export const useOffenceListStore = defineStore('OffenceListStore', {
  actions: {
    // 👉 Fetch offence data
    fetchOffenceItems(params: OffenceParams) {
      return axios.get('/api/enviro/master/offence', { params }) 
    },

    // 👉 Fetch offence by id
    fetchOffenceById(id: number) {
      return axios.get(`/api/enviro/master/offence/${id}`) 
    },

    // // 👉 Add offence
    addOffence(Data: Partial<OffenceProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/offence', 
          Data
        )
    },

    // 👉 Update offence status
   updateOffenceStatus(id:number,status:string) {
      return axios.put(`/api/enviro/master/offence/${id}/status`, 
        {status:status}
      )
    },

    // 👉 Update offence
    updateOffence(Data: Partial<OffenceProperties>) {
      let id=Data.id
      return axios.put(`/api/enviro/master/offence/${id}`,
        Data
      )
    },    
  },
})
