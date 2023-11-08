export interface ManualRepresentationReasonProperties {
  id: number
  reason:string
  status: string
}

export interface ManualRepresentationReasonParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}
