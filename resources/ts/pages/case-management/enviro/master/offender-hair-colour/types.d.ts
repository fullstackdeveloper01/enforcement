export interface OffenderHairColourProperties {
  id: number
  textOnMachine: string
  textOnLetter: string
  status: string
}

export interface OffenderHairColourParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}