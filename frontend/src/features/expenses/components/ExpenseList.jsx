function ExpenseList({ expenses }) {
  if (expenses.length === 0) {
    return <p>No expenses yet</p>;
  }

  return (
    <ul>
      {expenses.map((expense) => (
        <li key={expense.id}>
          {expense.label} - {expense.amount}€ ({expense.category})
        </li>
      ))}
    </ul>
  );
}

export default ExpenseList;