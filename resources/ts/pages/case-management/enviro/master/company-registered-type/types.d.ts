export interface CompanyRegisteredTypeProperties {
  id: number
  registered_type:string
  status: string
}

export interface CompanyRegisteredTypeParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}
 