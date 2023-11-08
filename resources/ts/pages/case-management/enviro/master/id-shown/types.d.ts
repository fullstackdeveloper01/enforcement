export interface IdShownProperties {
  id: number
  textOnMachine: string
  textOnLetter: string
  status: string
}

export interface IdShownParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}