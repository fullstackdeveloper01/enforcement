export interface CancelCodeProperties {
  id: number
  type: string
  description: string
  status: string
}

export interface CancelCodeParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}