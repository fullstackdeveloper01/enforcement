export interface OffenceGroupProperties {
  id: number
  englishName: string
  welshName: string
  type: string
  status: string
}

export interface OffenceGroupParams {
  q?: string,
  status: string,
  perPage?: number,
  currentPage?: number,
}