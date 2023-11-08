export interface ProducedWasteTransferProperties {
  id: number
  waste_transfer:string
  status: string
}

export interface ProducedWasteTransferParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}
 