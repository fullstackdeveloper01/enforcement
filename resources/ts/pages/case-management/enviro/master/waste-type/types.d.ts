export interface WasteTypeProperties {
  id: number
  waste_type:string
  status: string
}

export interface WasteTypeParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}
 