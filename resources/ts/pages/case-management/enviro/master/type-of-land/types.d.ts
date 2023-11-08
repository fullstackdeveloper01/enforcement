export interface TypeOfLandProperties {
  id: number
  name: string
  status: string
}

export interface TypeOfLandParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}