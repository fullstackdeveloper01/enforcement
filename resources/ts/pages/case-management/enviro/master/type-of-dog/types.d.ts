export interface TypeOfDogProperties {
  id: number
  name: string
  status: string
}

export interface TypeOfDogParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}