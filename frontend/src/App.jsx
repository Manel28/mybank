import { Routes, Route, Link } from 'react-router-dom';
import AddPage from './features/expenses/pages/AddPage';
import ListPage from './features/expenses/pages/ListPage';

function App() {
  return (
    <div style={{ padding: 20 }}>
      <nav>
        <Link to="/">Add</Link> | <Link to="/expenses">List</Link>
      </nav>

      <Routes>
        <Route path="/" element={<AddPage />} />
        <Route path="/expenses" element={<ListPage />} />
      </Routes>
    </div>
  );
}

export default App;