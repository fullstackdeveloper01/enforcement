import type { RepresentaionParams } from '@/pages/case-management/enviro/master/representation/types';
import axios from '@axios';
import { defineStore } from 'pinia';

export const useRepresentaionListStore = defineStore('OffenceGroupListStore', {
  actions: {
    // 👉 Fetch representation data
    fetchOffenceGroupItems(params: RepresentaionParams) { 
      if(params.lodgeDate && params.lodgeDate.indexOf('to') == -1) return false;
      return axios.get('/api/enviro/master/representation/list', { params }) 
    }
  },
})
