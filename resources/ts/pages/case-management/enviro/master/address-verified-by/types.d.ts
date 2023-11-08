export interface AddressVerifiedByProperties {
  id: number
  textOnMachine: string
  textOnLetter: string
  status: string
}

export interface AddressVerifiedByParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}