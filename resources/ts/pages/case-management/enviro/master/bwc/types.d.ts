export interface BwcProperties {
  id: number
  bwcNumber: string
  name: string
  status: string
}

export interface BwcParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}