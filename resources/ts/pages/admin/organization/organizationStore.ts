import axios from '@axios'
import { defineStore } from 'pinia'

export const useOrganizationStore = defineStore('OrganizationStore', {
  actions: {

    // 👉 Fetch Organization data
    getOrganizationDetail() { return axios.get('/api/company') },

    
  },
})






