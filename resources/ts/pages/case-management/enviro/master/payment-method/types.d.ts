export interface PaymentMethodProperties {
  id: number
  paymentMethod: string
  status: string
}

export interface PaymentMethodParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}