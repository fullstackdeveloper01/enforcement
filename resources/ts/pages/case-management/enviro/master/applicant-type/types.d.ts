export interface ApplicantTypeProperties {
  id: number
  applicant_type:string
  status: string
}

export interface ApplicantTypeParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}
