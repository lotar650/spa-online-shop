export const httpRoot = 'https://example.local'
export const clientSecret = 'UHeo5XTcxvheqDm74oIRni3bj0q3iea5ae27HHIZ'
export const getHeaders = () => {
  const user = JSON.parse(window.localStorage.getItem('authUser')) || {}
  const headers = {
    'Accept': 'application/json',
    'Authorization': 'Bearer ' + user.access_token
  }
  return headers
}
