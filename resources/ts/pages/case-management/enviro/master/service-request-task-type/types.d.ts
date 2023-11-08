export interface ServiceRequestTaskTypeProperties {
  id: number
  site_id:number
  task_type_name:string
  status: string
}

export interface ServiceRequestTaskTypeParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}
 