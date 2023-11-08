import type { UserParams, UserProperties } from '@/pages/admin/user/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useUserListStore = defineStore('UserListStore', {
  actions: {

    // 👉 Fetch user data
    fetchUserItems(params: UserParams) { return axios.get('/api/user', { params }) },

    // 👉 Add user
    addUser(Data: Partial<UserProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/user', 
          Data
        )
    },

    // 👉 Update user status
   updateUserStatus(id:number,status:string) {
      return axios.put('/api/user/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update user
    updateUser(Data: Partial<UserProperties>) {
      let id=Data.id
      return axios.put('/api/user/'+id, 
      Data
    )
    },
    
    fetchUser(id: number) {
      return axios.get(`/api/user/${id}`)
    },
    
    fetchAssignedSites(id: number)
    {
      return axios.get(`/api/user/${id}/sites`)
    },

  },
})
