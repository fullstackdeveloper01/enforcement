import type { DogSizeParams, DogSizeProperties } from '@/pages/case-management/enviro/master/dog-size/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useDogSizeListStore = defineStore('DogSizeListStore', {
  actions: {

    // 👉 Fetch dogsize data
    fetchDogSizeItems(params: DogSizeParams) { return axios.get('/api/enviro/master/dogsize', { params }) },

    // 👉 Add dogsize
    addDogSize(Data: Partial<DogSizeProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/dogsize', 
          Data
        )
    },

    // 👉 Update dogsize status
   updateDogSizeStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/dogsize/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update dogsize
    updateDogSize(Data: Partial<DogSizeProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/dogsize/'+id, 
      Data
    )
    },
    
  },
})
