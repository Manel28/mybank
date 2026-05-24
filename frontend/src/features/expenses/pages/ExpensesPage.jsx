import { useEffect, useState } from 'react';
import ExpenseForm from '../components/ExpenseForm';
import ExpenseList from '../components/ExpenseList';
import { createExpense, deleteExpense, getExpenses } from '../api/expenseApi';

function ExpensesPage() {
  const [expenses, setExpenses] = useState([]);

  useEffect(() => {
    getExpenses().then(setExpenses).catch(console.error);
  }, []);

  const handleCreate = async (expense) => {
    const createdExpense = await createExpense(expense);
    setExpenses((current) => [...current, createdExpense]);
  };

  const handleDelete = async (id) => {
    await deleteExpense(id);
    setExpenses((current) => current.filter((expense) => expense.id !== id));
  };

  return (
    <main>
      <h1>My Expenses</h1>
      <ExpenseForm onCreate={handleCreate} />
      <ExpenseList expenses={expenses} onDelete={handleDelete} />
    </main>
  );
}

export default ExpensesPage;