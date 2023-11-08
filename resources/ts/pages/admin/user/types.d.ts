export interface UserProperties {
  id: number
  textOnMachine: string
  textOnLetter: string
  status: string
}

export interface UserParams {
  q: string,
  status: string,
  role: string,
  perPage: number,
  currentPage: number,
}