const API_URL = 'http://localhost:8000/api/expenses';

export async function getExpenses() {
  const response = await fetch(API_URL);
  if (!response.ok) throw new Error('Failed to fetch expenses');
  return response.json();
}

export async function createExpense(expense) {
  const response = await fetch(API_URL, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(expense),
  });

  if (!response.ok) throw new Error('Failed to create expense');
  return response.json();
}

export async function deleteExpense(id) {
  const response = await fetch(`${API_URL}/${id}`, {
    method: 'DELETE',
  });

  if (!response.ok) throw new Error('Failed to delete expense');
}