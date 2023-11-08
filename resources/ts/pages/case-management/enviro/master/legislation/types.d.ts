export interface LegislationProperties {
  id: number
  title: string
  legislation: string
  language: string
  offenceSpecificText: string
  status: string
}

export interface LegislationParams {
  q?: string,
  status: string,
  perPage?: number,
  currentPage?: number,
}