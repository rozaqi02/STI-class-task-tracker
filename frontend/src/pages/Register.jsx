import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../services/api';

export default function Register() {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [role, setRole] = useState('siswa');
  const [message, setMessage] = useState('');
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await api.post('/auth/register', { name, email, password, role });
      setMessage('Registrasi berhasil, silakan login');
      setTimeout(() => navigate('/login'), 1500);
    } catch (err) {
      setMessage('Registrasi gagal');
    }
  };

  return (
    <div style={{ maxWidth: 400, margin: '50px auto' }}>
      <h2>Register</h2>
      {message && <p>{message}</p>}
      <form onSubmit={handleSubmit}>
        <div>
          <label>Nama</label><br />
          <input value={name} onChange={(e) => setName(e.target.value)} required />
        </div>
        <div style={{ marginTop: 10 }}>
          <label>Email</label><br />
          <input type="email" value={email} onChange={(e) => setEmail(e.target.value)} required />
        </div>
        <div style={{ marginTop: 10 }}>
          <label>Password</label><br />
          <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} required />
        </div>
        <div style={{ marginTop: 10 }}>
          <label>Role</label><br />
          <select value={role} onChange={(e) => setRole(e.target.value)}>
            <option value="siswa">Siswa</option>
            <option value="guru">Guru</option>
          </select>
        </div>
        <button type="submit" style={{ marginTop: 15 }}>Register</button>
      </form>
    </div>
  );
}