import type { ProducedWasteTransferParams, ProducedWasteTransferProperties } from '@/pages/case-management/enviro/master/produced-waste-transfer/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useProducedWasteTransferListStore = defineStore('ProducedWasteTransferListStore', {
  actions: {

    // 👉 Fetch produced waste transfer data 
    fetchProducedWasteTransferItems(params: ProducedWasteTransferParams) { return axios.get('/api/enviro/master/producedwastetransfer', { params }) },

    // 👉 Add produced waste transfer
    addProducedWasteTransfer(Data: Partial<ProducedWasteTransferProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/producedwastetransfer', 
          Data
        )
    },

    // 👉 Update produced waste transfer status
   updateProducedWasteTransferStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/producedwastetransfer/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update produced waste transfer
    updateProducedWasteTransfer(Data: Partial<ProducedWasteTransferProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/producedwastetransfer/'+id, 
      Data
    )
    },
    
  },
})

