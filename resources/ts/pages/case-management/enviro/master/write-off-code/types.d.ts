export interface WriteOffCodeProperties {
  id: number
  type: string
  description: string
  status: string
}

export interface WriteOffCodeParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}