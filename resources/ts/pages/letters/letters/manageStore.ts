import type { SiteProperties } from '@/pages/setup/sites/types';
import axios from '@axios';
import { defineStore } from 'pinia';

export const manageStore = defineStore('LetterListStore', {
  actions: {

    // 👉 Fetch site data
    fetchSites() {
      return axios.get('/api/sites') 
    },

    fetchGroups(){
        return axios.get('/api/letters/groups') 
    },

    fetchOffences(){
        return axios.get('/api/offence-groups/fetch') 
    },

    // // 👉 Add Site
    createSite(Data: Partial<SiteProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/sites', 
          Data,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
        )
    },

    // 👉 Update user status
   updateUserStatus(id:number,status:string) {
      return axios.put('/api/user/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update user
    update(Data: Partial<SiteProperties>) {
        let id=Data.id
        return axios.post('/api/site/'+id, 
        Data,
        {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }
      )
    },

    updateEnviro(Data: Partial<SiteProperties>) {
      let id=Data.id
      return axios.post('/api/sites/'+id+'/enviro/update', 
        Data
      )
    },

    addArea(Data) {
      let id=Data.site_id
      return axios.post('/api/sites/'+id+'/area/create', 
        Data
      )
    },

    updateArea(Data) {
      let id=Data.site_id
      return axios.post('/api/sites/'+id+'/area/update', 
        Data
      )
    },

    updateZone(Data){
      let id=Data.id
      return axios.post('/api/sites/'+id+'/zone/update', 
        Data
      )
    },

    deleteArea(id){
      let Data = [];
      return axios.post('/api/sites/area/'+id+'/delete', 
        Data
      )
    },

    deleteZone(id){
      let Data = [];
      return axios.post('/api/sites/zone/'+id+'/delete', 
        Data
      )
    },
    updateOffence(Data){
      return axios.post('/api/site-offence/update', 
        Data
      )
    },

    deleteOffence(id)
    {
      let Data = [];
      return axios.post('/api/site-offence/'+id+'/delete', 
        Data
      )
    },

    
    fetchSite(id: number) {
      return axios.get(`/api/site/${id}/find`)
    },

    createZone(Data)
    { 
      delete Data.id;
      delete Data.status;
      return axios.post('/api/zones', 
        Data
      )
    },

    updateStatus(id: number)
    {
      return axios.post(`/api/site/status`, {
        id: id
      });
    }
    
  },
})
