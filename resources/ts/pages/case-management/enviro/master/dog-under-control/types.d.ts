export interface DogUnderControlProperties {
  id: number
  name: string
  status: string
}

export interface DogUnderControlParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}