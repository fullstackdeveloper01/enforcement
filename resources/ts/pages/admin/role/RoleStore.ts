import type { RoleParams, RoleProperties } from "@/pages/admin/role/types";
import axios from "@axios";
import { defineStore } from "pinia";

export const useRoleStore = defineStore("RoleStore", {
  actions: {
    // 👉 Fetch Role data
    listRole(params: RoleParams) {
      return axios.get("/api/role", { params });
    },

    // 👉 Add Role
    addRole(offencHowData: Partial<RoleProperties>) {
      delete offencHowData.id;
      delete offencHowData.status;
      return axios.post("/api/role/add", offencHowData);
    },

    // 👉 Update Role status
    updateRoleStatus(id: number, status: string) {
      return axios.put("/api/role/" + id + "/status", {
        status: status,
      });
    },

    // 👉 Update Role
    updateRole(offencHowData: Partial<RoleProperties>) {
      let id = offencHowData.id;
      delete offencHowData.id;
      delete offencHowData.status;
      return axios.put("/api/role/"+ id+"/edit", offencHowData);
    },
  },
});
