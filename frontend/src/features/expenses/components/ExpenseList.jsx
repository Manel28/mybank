function ExpenseList({ expenses, onDelete }) {
  if (expenses.length === 0) {
    return <p>No expenses yet</p>;
  }

  return (
    <ul>
      {expenses.map((expense) => (
        <li key={expense.id}>
          {expense.label} - {expense.amount}€ ({expense.category}){' '}
          <button
            type="button"
            onClick={() => {
              console.log('DELETE CLICKED', expense.id);
              onDelete(expense.id);
            }}
          >
            Delete
          </button>
        </li>
      ))}
    </ul>
  );
}

export default ExpenseList;