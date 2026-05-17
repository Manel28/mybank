const API_URL = 'http://localhost:8000/api/expenses';

export async function getExpenses() {
  const response = await fetch(API_URL);
  return response.json();
}