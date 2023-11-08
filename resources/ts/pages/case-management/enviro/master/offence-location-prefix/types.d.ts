export interface OffenceLocationPrefixProperties {
  id: number
  textOnMachine: string
  textOnLetter: string
  status: string
}

export interface OffenceLocationPrefixParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}