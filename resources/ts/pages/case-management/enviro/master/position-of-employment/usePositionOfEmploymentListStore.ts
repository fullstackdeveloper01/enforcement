import type { PositionOfEmploymentParams, PositionOfEmploymentProperties } from '@/pages/case-management/enviro/master/position-of-employment/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const usePositionOfEmploymentListStore = defineStore('PositionOfEmploymentListStore', {
  actions: {

    // 👉 Fetch positionofemployment data 
    fetchPositionOfEmploymentItems(params: PositionOfEmploymentParams) { return axios.get('/api/enviro/master/positionofemployment', { params }) },

    // 👉 Add positionofemployment
    addPositionOfEmployment(Data: Partial<PositionOfEmploymentProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/positionofemployment', 
          Data
        )
    },

    // 👉 Update positionofemployment status
   updatePositionOfEmploymentStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/positionofemployment/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update positionofemployment
    updatePositionOfEmployment(Data: Partial<PositionOfEmploymentProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/positionofemployment/'+id, 
      Data
    )
    },
    
  },
})

