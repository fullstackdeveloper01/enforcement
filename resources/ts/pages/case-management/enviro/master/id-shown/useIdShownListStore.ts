import type { IdShownParams, IdShownProperties } from '@/pages/case-management/enviro/master/id-shown/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useIdShownListStore = defineStore('IdShownListStore', {
  actions: {

    // 👉 Fetch idshown data
    fetchIdShownItems(params: IdShownParams) { return axios.get('/api/enviro/master/idshown', { params }) },

    // 👉 Add idshown
    addIdShown(Data: Partial<IdShownProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/idshown', 
          Data
        )
    },

    // 👉 Update idshown status
   updateIdShownStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/idshown/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update idshown
    updateIdShown(Data: Partial<IdShownProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/idshown/'+id, 
      Data
    )
    },
    
  },
})
