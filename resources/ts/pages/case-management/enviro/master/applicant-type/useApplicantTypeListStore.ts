import type { ApplicantTypeParams, ApplicantTypeProperties } from '@/pages/case-management/enviro/master/applicant-type/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useApplicantTypeListStore = defineStore('ApplicantTypeListStore', {
  actions: {

    // 👉 Fetch applicant type data 
    fetchApplicantTypeItems(params: ApplicantTypeParams) { return axios.get('/api/enviro/master/applicanttype', { params }) },

    // 👉 Add applicant type
    addApplicantType(Data: Partial<ApplicantTypeProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/applicanttype', 
          Data
        )
    },

    // 👉 Update applicant type status
   updateApplicantTypeStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/applicanttype/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update applicant type
    updateApplicantType(Data: Partial<ApplicantTypeProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/applicanttype/'+id, 
      Data
    )
    },
    
  },
})

