import type { OffenderHairColourParams, OffenderHairColourProperties } from '@/pages/case-management/enviro/master/offender-hair-colour/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useOffenderHairColourListStore = defineStore('OffenderHairColourListStore', {
  actions: {

    // 👉 Fetch offenderhaircolour data
    fetchOffenderHairColourItems(params: OffenderHairColourParams) { return axios.get('/api/enviro/master/offenderhaircolour', { params }) },

    // 👉 Add offenderhaircolour
    addOffenderHairColour(Data: Partial<OffenderHairColourProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/offenderhaircolour', 
          Data
        )
    },

    // 👉 Update offenderhaircolour status
   updateOffenderHairColourStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/offenderhaircolour/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update offenderhaircolour
    updateOffenderHairColour(Data: Partial<OffenderHairColourProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/offenderhaircolour/'+id, 
      Data
    )
    },
    
  },
})
