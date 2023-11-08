export interface ServiceRequestReportedViaProperties {
  id: number
  reported_via:string
  is_online:string
  is_back_office:string
  status: string
}

export interface ServiceRequestReportedViaParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}
 