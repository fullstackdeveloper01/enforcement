import type { AddressVerifiedByParams, AddressVerifiedByProperties } from '@/pages/case-management/enviro/master/address-verified-by/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useAddressVerifiedByListStore = defineStore('AddressVerifiedByListStore', {
  actions: {

    // 👉 Fetch addressverifiedby data
    fetchAddressVerifiedByItems(params: AddressVerifiedByParams) { return axios.get('/api/enviro/master/addressverifiedby', { params }) },

    // 👉 Add addressverifiedby
    addAddressVerifiedBy(Data: Partial<AddressVerifiedByProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/addressverifiedby', 
          Data
        )
    },

    // 👉 Update addressverifiedby status
   updateAddressVerifiedByStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/addressverifiedby/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update addressverifiedby
    updateAddressVerifiedBy(Data: Partial<AddressVerifiedByProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/addressverifiedby/'+id, 
      Data
    )
    },
    
  },
})
