export interface ServiceRequestClosedCodesProperties {
  id: number
  closed_code_type:string
  closed_code_description:string
  status: string
}

export interface ServiceRequestClosedCodesParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}
 