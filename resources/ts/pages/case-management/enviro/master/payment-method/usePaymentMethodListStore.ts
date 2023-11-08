import type { PaymentMethodParams, PaymentMethodProperties } from '@/pages/case-management/enviro/master/payment-method/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const usePaymentMethodListStore = defineStore('PaymentMethodListStore', {
  actions: {

    // 👉 Fetch paymentmethod data
    fetchPaymentMethodItems(params: PaymentMethodParams) { return axios.get('/api/enviro/master/paymentmethod', { params }) },

    // 👉 Add paymentmethod
    addPaymentMethod(Data: Partial<PaymentMethodProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/paymentmethod', 
          Data
        )
    },

    // 👉 Update paymentmethod status
   updatePaymentMethodStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/paymentmethod/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update paymentmethod
    updatePaymentMethod(Data: Partial<PaymentMethodProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/paymentmethod/'+id, 
      Data
    )
    },
    
  },
})
