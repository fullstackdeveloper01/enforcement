export interface WeatherProperties {
  id: number
  textOnMachine: string
  textOnLetter: string
  status: string
}

export interface WeatherParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}