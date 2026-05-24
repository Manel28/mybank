import { useState } from 'react';

function ExpenseForm({ onCreate }) {
  const [form, setForm] = useState({
    label: '',
    amount: '',
    date: '',
    category: '',
  });

  const handleChange = (event) => {
    setForm({ ...form, [event.target.name]: event.target.value });
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    console.log('ADD CLICKED', form);

    await onCreate({
      label: form.label,
      amount: Number(form.amount),
      date: form.date,
      category: form.category,
    });

    setForm({ label: '', amount: '', date: '', category: '' });
  };

  return (
    <form onSubmit={handleSubmit}>
      <h2>Add Expense</h2>

      <input name="label" placeholder="Label" value={form.label} onChange={handleChange} required />
      <input name="amount" type="number" placeholder="Amount" value={form.amount} onChange={handleChange} required />
      <input name="date" type="date" value={form.date} onChange={handleChange} required />
      <input name="category" placeholder="Category" value={form.category} onChange={handleChange} required />

      <button type="submit">Add</button>
    </form>
  );
}

export default ExpenseForm;