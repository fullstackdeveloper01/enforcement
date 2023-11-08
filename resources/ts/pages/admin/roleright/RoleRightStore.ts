import type { RoleRightParams } from '@/pages/admin/roleright/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useRoleRightStore = defineStore('RoleRightStore', {
  actions: {

    // 👉 Fetch Role rights data
    listRoleRights(params: RoleRightParams, userId: string) { return axios.get('/api/role/role-permission/'+userId, { params }) },
    // 👉 Update permission of role
    updatePermissionRole(role: string, permission:string, status: boolean) {return axios.put('/api/role/'+role+'/permission/'+permission+'/status/'+status)},
  },
})
