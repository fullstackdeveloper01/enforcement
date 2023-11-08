export interface PositionOfEmploymentProperties {
  id: number
  position_of_employment:string
  status: string
}

export interface PositionOfEmploymentParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}
 