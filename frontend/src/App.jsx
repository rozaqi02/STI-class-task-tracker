import { Routes, Route, Navigate } from 'react-router-dom';
import Login from './pages/Login';
import Register from './pages/Register';
import Tasks from './pages/Tasks';

function App() {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />
      <Route path="/" element={<Navigate to="/login" />} />
      <Route path="/tasks" element={<Tasks />} />
<Route path="/tasks/create" element={<div>Halaman Buat Tugas (segera dibuat)</div>} />
<Route path="/tasks/edit/:id" element={<div>Halaman Edit Tugas (segera dibuat)</div>} />
    </Routes>
  );
}

export default App;