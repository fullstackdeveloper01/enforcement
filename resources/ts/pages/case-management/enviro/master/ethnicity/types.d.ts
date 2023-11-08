export interface EthnicityProperties {
  id: number
  textOnMachine: string
  textOnLetter: string
  status: string
}

export interface EthnicityParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}