import type { TypeOfLandParams, TypeOfLandProperties } from '@/pages/case-management/enviro/master/type-of-land/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useTypeOfLandListStore = defineStore('TypeOfLandListStore', {
  actions: {

    // 👉 Fetch typeofland data
    fetchTypeOfLandItems(params: TypeOfLandParams) { return axios.get('/api/enviro/master/typeofland', { params }) },

    // 👉 Add typeofland
    addTypeOfLand(Data: Partial<TypeOfLandProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/typeofland', 
          Data
        )
    },

    // 👉 Update typeofland status
   updateTypeOfLandStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/typeofland/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update typeofland
    updateTypeOfLand(Data: Partial<TypeOfLandProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/typeofland/'+id, 
      Data
    )
    },
    
  },
})
