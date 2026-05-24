import { useEffect, useState } from 'react';
import { getExpenses, deleteExpense } from '../api/expenseApi';

function ListPage() {
  const [expenses, setExpenses] = useState([]);

  const load = async () => {
    const data = await getExpenses();
    setExpenses(data);
  };

  useEffect(() => {
    load();
  }, []);

  const handleDelete = async (id) => {
    await deleteExpense(id);
    setExpenses((old) => old.filter((e) => e.id !== id));
  };

  return (
    <div>
      <h1>Expenses</h1>

      {expenses.length === 0 ? (
        <p>No expenses</p>
      ) : (
        <ul>
          {expenses.map((e) => (
            <li key={e.id}>
              {e.label} - {e.amount}€
              <button onClick={() => handleDelete(e.id)}>Delete</button>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}

export default ListPage;