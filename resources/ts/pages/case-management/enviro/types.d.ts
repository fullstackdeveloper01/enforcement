export interface EnviroProperties {
  id: number
  textOnMachine: string
  textOnLetter: string
  status: string
}

export interface EnviroParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}