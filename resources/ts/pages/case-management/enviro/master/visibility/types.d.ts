export interface VisibilityProperties {
  id: number
  visibility: string
  status: string
}

export interface VisibilityParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}