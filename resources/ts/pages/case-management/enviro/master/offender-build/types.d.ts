export interface OffenderBuildProperties {
  id: number
  textOnMachine: string
  textOnLetter: string
  status: string
}

export interface OffenderBuildParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}