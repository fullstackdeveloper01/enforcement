export interface ServiceRequestTaskGroupProperties {
  id: number
  site_id:number
  task_type_ids:Array
  task_group_name:string
  status: string
}

export interface ServiceRequestTaskGroupParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}
 