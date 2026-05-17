import { useEffect, useState } from 'react';
import ExpenseList from '../components/ExpenseList';
import ExpenseForm from '../components/ExpenseForm';
import { getExpenses } from '../services/expenseApi';

function ExpensesPage() {
  const [expenses, setExpenses] = useState([]);

  const loadExpenses = () => {
    getExpenses()
      .then(setExpenses)
      .catch(console.error);
  };

  useEffect(() => {
    loadExpenses();
  }, []);

  return (
    <main>
      <h1>My Expenses</h1>

      <ExpenseForm onAdd={loadExpenses} />

      <ExpenseList expenses={expenses} />
    </main>
  );
}

export default ExpensesPage;