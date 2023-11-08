import type { CompanyRegisteredTypeParams, CompanyRegisteredTypeProperties } from '@/pages/case-management/enviro/master/company-registered-type/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useCompanyRegisteredTypeListStore = defineStore('CompanyRegisteredTypeListStore', {
  actions: {

    // 👉 Fetch Company Registered type data 
    fetchCompanyRegisteredTypeItems(params: CompanyRegisteredTypeParams) { return axios.get('/api/enviro/master/companyregisterdtype', { params }) },

    // 👉 Add Company Registered type
    addCompanyRegisteredType(Data: Partial<CompanyRegisteredTypeProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/companyregisterdtype', 
          Data
        )
    },

    // 👉 Update Company Registered type status
   updateCompanyRegisteredTypeStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/companyregisterdtype/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update Company Registered type
    updateCompanyRegisteredType(Data: Partial<CompanyRegisteredTypeProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/companyregisterdtype/'+id, 
      Data
    )
    },
    
  },
})

