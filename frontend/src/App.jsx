import { Routes, Route, Navigate } from 'react-router-dom';
import Login from './pages/Login';
import Register from './pages/Register';
import Tasks from './pages/Tasks';
import TaskForm from './pages/TaskForm';

function App() {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />
      <Route path="/" element={<Navigate to="/login" />} />
      <Route path="/tasks" element={<Tasks />} />
      <Route path="/tasks/create" element={<TaskForm />} />
      <Route path="/tasks/edit/:id" element={<TaskForm />} />
    </Routes>
  );
}

export default App;