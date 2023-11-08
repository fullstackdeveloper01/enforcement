export interface RegionProperties {
  id: number
  region: string
  status: string
}

export interface RegionParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}