export interface OffenceProperties {
  id: number
  name: string
  welshName: string
  description: string
  welshDescription: string
  englishLegislation: string
  welshLegislation: string
  group: string
  minImageRequired: string
  maxFine: string
  issueType: string
  status: string
}

export interface OffenceParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}