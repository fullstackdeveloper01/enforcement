import type { TypeOfDogParams, TypeOfDogProperties } from '@/pages/case-management/enviro/master/type-of-dog/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useTypeOfDogListStore = defineStore('TypeOfDogListStore', {
  actions: {

    // 👉 Fetch typeofdog data
    fetchTypeOfDogItems(params: TypeOfDogParams) { return axios.get('/api/enviro/master/typeofdog', { params }) },

    // 👉 Add typeofdog
    addTypeOfDog(Data: Partial<TypeOfDogProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/typeofdog', 
          Data
        )
    },

    // 👉 Update typeofdog status
   updateTypeOfDogStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/typeofdog/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update typeofdog
    updateTypeOfDog(Data: Partial<TypeOfDogProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/typeofdog/'+id, 
      Data
    )
    },
    
  },
})
