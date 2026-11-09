import { useEffect, useState } from 'react';
import api from '../services/api';
import { useAuth } from '../context/AuthContext';
import { useNavigate } from 'react-router-dom';

export default function Tasks() {
  const [tasks, setTasks] = useState([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [status, setStatus] = useState('');
  const { user, logout } = useAuth();
  const navigate = useNavigate();

  const fetchTasks = async () => {
    setLoading(true);
    try {
      const params = {};
      if (search) params.search = search;
      if (status) params.status = status;

      const res = await api.get('/tasks', { params });
      setTasks(res.data.data);
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchTasks();
  }, [search, status]);

  const handleComplete = async (id) => {
    try {
      await api.post(`/tasks/${id}/complete`);
      fetchTasks();
    } catch (err) {
      alert('Gagal menandai selesai');
    }
  };

  const handleDelete = async (id) => {
    if (!confirm('Yakin hapus tugas ini?')) return;
    try {
      await api.delete(`/tasks/${id}`);
      fetchTasks();
    } catch (err) {
      alert('Gagal menghapus');
    }
  };

  return (
    <div style={{ padding: 20, maxWidth: 800, margin: '0 auto' }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <h2>Daftar Tugas</h2>
        <div>
          <span>Halo, {user?.name} ({user?.role})</span>
          <button onClick={() => { logout(); navigate('/login'); }}>Logout</button>
        </div>
      </div>

      {user?.role === 'guru' && (
        <button onClick={() => navigate('/tasks/create')} style={{ margin: '10px 0' }}>
          + Buat Tugas Baru
        </button>
      )}

      <div style={{ margin: '15px 0', display: 'flex', gap: 10 }}>
        <input
          placeholder="Cari judul..."
          value={search}
          onChange={(e) => setSearch(e.target.value)}
        />
        <select value={status} onChange={(e) => setStatus(e.target.value)}>
          <option value="">Semua Status</option>
          <option value="pending">Belum Selesai</option>
          <option value="completed">Selesai</option>
        </select>
      </div>

      {loading ? (
        <p>Loading...</p>
      ) : (
        <ul style={{ listStyle: 'none', padding: 0 }}>
          {tasks.map((task) => (
            <li key={task.id} style={{ border: '1px solid #ddd', padding: 12, marginBottom: 10, borderRadius: 6 }}>
              <strong>{task.title}</strong>
              <p>{task.description}</p>
              <small>Tenggat: {task.due_date}</small>
              <div style={{ marginTop: 8 }}>
                Status: {task.is_completed ? '✅ Selesai' : '⏳ Belum'}
              </div>

              <div style={{ marginTop: 10 }}>
                {user?.role === 'siswa' && !task.is_completed && (
                  <button onClick={() => handleComplete(task.id)}>Tandai Selesai</button>
                )}
                {user?.role === 'guru' && (
                  <>
                    <button onClick={() => navigate(`/tasks/edit/${task.id}`)} style={{ marginRight: 8 }}>
                      Edit
                    </button>
                    <button onClick={() => handleDelete(task.id)} className="danger">
                      Hapus
                    </button>
                  </>
                )}
              </div>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}