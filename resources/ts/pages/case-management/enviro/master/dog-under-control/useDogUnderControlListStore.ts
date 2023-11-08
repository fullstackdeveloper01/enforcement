import type { DogUnderControlParams, DogUnderControlProperties } from '@/pages/case-management/enviro/master/dog-under-control/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useDogUnderControlListStore = defineStore('DogUnderControlListStore', {
  actions: {

    // 👉 Fetch dogundercontrol data
    fetchDogUnderControlItems(params: DogUnderControlParams) { return axios.get('/api/enviro/master/dogundercontrol', { params }) },

    // 👉 Add dogundercontrol
    addDogUnderControl(Data: Partial<DogUnderControlProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/dogundercontrol', 
          Data
        )
    },

    // 👉 Update dogundercontrol status
   updateDogUnderControlStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/dogundercontrol/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update dogundercontrol
    updateDogUnderControl(Data: Partial<DogUnderControlProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/dogundercontrol/'+id, 
      Data
    )
    },
    
  },
})
