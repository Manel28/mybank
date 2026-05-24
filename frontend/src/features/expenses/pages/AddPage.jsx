import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { createExpense } from '../api/expenseApi';

function AddPage() {
  const navigate = useNavigate();

  const [form, setForm] = useState({
    label: '',
    amount: '',
    date: '',
    category: '',
  });

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    await createExpense({
      label: form.label,
      amount: Number(form.amount),
      date: form.date,
      category: form.category,
    });

    setForm({ label: '', amount: '', date: '', category: '' });

    navigate('/expenses');
  };

  return (
    <div>
      <h1>Add Expense</h1>

      <form onSubmit={handleSubmit}>
        <input name="label" placeholder="Label" value={form.label} onChange={handleChange} required />
        <input name="amount" type="number" placeholder="Amount" value={form.amount} onChange={handleChange} required />
        <input name="date" type="date" value={form.date} onChange={handleChange} required />
        <input name="category" placeholder="Category" value={form.category} onChange={handleChange} required />
        <button type="submit">Add</button>
      </form>
    </div>
  );
}

export default AddPage;