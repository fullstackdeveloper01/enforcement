export interface OffenceHowProperties {
  id: number
  textOnMachine: string
  textOnLetter: string
  status: string
}

export interface OffenceHowParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}