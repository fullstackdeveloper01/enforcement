export interface DogSizeProperties {
  id: number
  name: string
  status: string
}

export interface DogSizeParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}