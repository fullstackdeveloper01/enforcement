export interface OffenceLocationSuffixProperties {
  id: number
  textOnMachine: string
  textOnLetter: string
  status: string
}

export interface OffenceLocationSuffixParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}