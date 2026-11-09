import { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import api from '../services/api';

export default function TaskForm() {
  const { id } = useParams();
  const navigate = useNavigate();
  const isEdit = Boolean(id);

  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [dueDate, setDueDate] = useState('');
  const [classId, setClassId] = useState(1);
  const [loading, setLoading] = useState(false);
  const [fetching, setFetching] = useState(isEdit);

  useEffect(() => {
    if (isEdit) {
      api.get('/tasks')
        .then(res => {
          const task = res.data.data.find(t => t.id == id);
          if (task) {
            setTitle(task.title);
            setDescription(task.description);
            setDueDate(task.due_date);
            setClassId(task.class_id);
          }
        })
        .catch(() => alert('Gagal memuat data tugas'))
        .finally(() => setFetching(false));
    }
  }, [id]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);

    const payload = {
      title,
      description,
      due_date: dueDate,
      class_id: classId,
    };

    try {
      if (isEdit) {
        await api.put(`/tasks/${id}`, payload);
      } else {
        await api.post('/tasks', payload);
      }
      navigate('/tasks');
    } catch (err) {
      alert('Gagal menyimpan tugas');
    } finally {
      setLoading(false);
    }
  };

  if (fetching) {
    return <p style={{ textAlign: 'center', marginTop: 40 }}>Memuat data tugas...</p>;
  }

  return (
    <div style={{ maxWidth: 500, margin: '40px auto', padding: 20 }}>
      <h2>{isEdit ? 'Edit Tugas' : 'Buat Tugas Baru'}</h2>

      <form onSubmit={handleSubmit}>
        <div style={{ marginBottom: 12 }}>
          <label>Judul</label><br />
          <input
            value={title}
            onChange={(e) => setTitle(e.target.value)}
            required
            style={{ width: '100%', padding: 8 }}
          />
        </div>

        <div style={{ marginBottom: 12 }}>
          <label>Deskripsi</label><br />
          <textarea
            value={description}
            onChange={(e) => setDescription(e.target.value)}
            required
            rows={4}
            style={{ width: '100%', padding: 8 }}
          />
        </div>

        <div style={{ marginBottom: 12 }}>
          <label>Tenggat</label><br />
          <input
            type="date"
            value={dueDate}
            onChange={(e) => setDueDate(e.target.value)}
            required
            style={{ padding: 8 }}
          />
        </div>

        <div style={{ marginBottom: 12 }}>
          <label>ID Kelas</label><br />
          <input
            type="number"
            value={classId}
            onChange={(e) => setClassId(e.target.value)}
            required
            style={{ padding: 8 }}
          />
        </div>

        <button type="submit" disabled={loading}>
          {loading ? 'Menyimpan...' : 'Simpan'}
        </button>
        <button type="button" onClick={() => navigate('/tasks')} style={{ marginLeft: 10 }}>
          Batal
        </button>
      </form>
    </div>
  );
}