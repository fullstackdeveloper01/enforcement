import type { WriteOffCodeParams, WriteOffCodeProperties } from '@/pages/case-management/enviro/master/write-off-code/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useWriteOffCodeListStore = defineStore('WriteOffCodeListStore', {
  actions: {

    // 👉 Fetch writeoffcode data
    fetchWriteOffCodeItems(params: WriteOffCodeParams) { return axios.get('/api/enviro/master/writeoffcode', { params }) },

    // 👉 Add writeoffcode
    addWriteOffCode(Data: Partial<WriteOffCodeProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/writeoffcode', 
          Data
        )
    },

    // 👉 Update writeoffcode status
   updateWriteOffCodeStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/writeoffcode/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update writeoffcode
    updateWriteOffCode(Data: Partial<WriteOffCodeProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/writeoffcode/'+id, 
      Data
    )
    },
    
  },
})
